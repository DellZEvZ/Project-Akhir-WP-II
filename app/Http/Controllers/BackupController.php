<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use ZipArchive;
use App\Helpers\ActivityLogger;
use App\Traits\HasPermissionCheck;

class BackupController extends Controller
{
    use HasPermissionCheck;

    protected $backupPath;

    public function __construct()
    {
        // Path untuk menyimpan backup di storage/app/backups
        $this->backupPath = storage_path('app/backups');

        // Buat folder jika belum ada
        if (!File::exists($this->backupPath)) {
            File::makeDirectory($this->backupPath, 0755, true);
        }
    }

    /**
     * Display backup & restore page
     */
    public function index()
    {
        if ($response = $this->checkPermission('backup.manage', 'Anda tidak memiliki izin untuk mengakses backup & restore.')) {
            return $response;
        }

        // Get all backup files
        $backups = [];
        $files = File::files($this->backupPath);

        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) === 'zip') {
                $backups[] = [
                    'name' => basename($file),
                    'size' => $this->formatBytes(filesize($file)),
                    'size_bytes' => filesize($file),
                    'date' => date('Y-m-d H:i:s', filemtime($file)),
                    'path' => $file
                ];
            }
        }

        // Sort by date descending
        usort($backups, function($a, $b) {
            return strtotime($b['date']) - strtotime($a['date']);
        });

        // Statistics
        $totalBackups = count($backups);
        $totalSize = array_sum(array_column($backups, 'size_bytes'));
        $lastBackup = $backups[0] ?? null;

        return view('backend.v_setting.backup', [
            'judul' => 'Backup & Restore Data',
            'backups' => $backups,
            'totalBackups' => $totalBackups,
            'totalSize' => $this->formatBytes($totalSize),
            'lastBackup' => $lastBackup,
        ]);
    }

    /**
     * Create new backup
     */
    public function create()
    {
        if ($response = $this->checkPermission('backup.manage', 'Anda tidak memiliki izin untuk membuat backup.')) {
            return $response;
        }

        try {
            $timestamp = date('Y-m-d_His');
            $backupName = "backup_{$timestamp}";

            // 1. Backup Database
            $sqlFile = $this->backupPath . "/{$backupName}.sql";
            $this->backupDatabase($sqlFile);

            // 2. Create ZIP and add SQL
            $zipFile = $this->backupPath . "/{$backupName}.zip";
            $zip = new ZipArchive();

            if ($zip->open($zipFile, ZipArchive::CREATE) === TRUE) {
                // Add SQL file
                $zip->addFile($sqlFile, basename($sqlFile));

                // 3. Backup Storage Files (optional - bisa dikomen jika tidak perlu)
                $this->addStorageToZip($zip);

                $zip->close();
            }

            // Delete temporary SQL file
            if (file_exists($sqlFile)) {
                unlink($sqlFile);
            }

            // Log activity
            ActivityLogger::log('create', 'backup', "Membuat backup database: {$backupName}.zip");

            return redirect()
                ->route('backend.setting.backup')
                ->with('success', 'Backup berhasil dibuat!');

        } catch (\Exception $e) {
            return redirect()
                ->route('backend.setting.backup')
                ->with('error', 'Gagal membuat backup: ' . $e->getMessage());
        }
    }

    /**
     * Backup database using mysqldump or PHP fallback
     */
    protected function backupDatabase($sqlFile)
    {
        $dbHost = env('DB_HOST', '127.0.0.1');
        $dbName = env('DB_DATABASE');
        $dbUser = env('DB_USERNAME');
        $dbPass = env('DB_PASSWORD');

        // Try to find mysqldump
        $mysqldumpPath = $this->findMysqldump();

        if ($mysqldumpPath) {
            // Use mysqldump
            $command = sprintf(
                '"%s" -h %s -u %s --password=%s %s > "%s" 2>&1',
                $mysqldumpPath,
                $dbHost,
                $dbUser,
                $dbPass,
                $dbName,
                $sqlFile
            );

            exec($command, $output, $returnVar);

            if ($returnVar === 0 && file_exists($sqlFile) && filesize($sqlFile) > 0) {
                return; // Success
            }
        }

        // Fallback: PHP-based backup
        $this->backupDatabasePHP($sqlFile);
    }

    /**
     * Find mysqldump executable
     */
    protected function findMysqldump()
    {
        // Common paths for mysqldump
        $paths = [
            'mysqldump', // If in PATH
            'C:\laragon\bin\mysql\mysql-8.0.30\bin\mysqldump.exe',
            'C:\laragon\bin\mysql\mysql-5.7.33\bin\mysqldump.exe',
            'C:\xampp\mysql\bin\mysqldump.exe',
            'C:\wamp64\bin\mysql\mysql8.0.27\bin\mysqldump.exe',
        ];

        // Check Laragon dynamic path
        if (file_exists('C:\laragon\bin\mysql')) {
            $mysqlDirs = glob('C:\laragon\bin\mysql\mysql-*');
            foreach ($mysqlDirs as $dir) {
                $paths[] = $dir . '\bin\mysqldump.exe';
            }
        }

        foreach ($paths as $path) {
            // Test if command exists
            exec("\"$path\" --version 2>NUL", $output, $returnVar);
            if ($returnVar === 0) {
                return $path;
            }
        }

        return null;
    }

    /**
     * PHP-based database backup (fallback)
     */
    protected function backupDatabasePHP($sqlFile)
    {
        $dbHost = env('DB_HOST', '127.0.0.1');
        $dbName = env('DB_DATABASE');
        $dbUser = env('DB_USERNAME');
        $dbPass = env('DB_PASSWORD');
        $dbPort = env('DB_PORT', '3306');

        try {
            // Connect to database
            $pdo = new \PDO(
                "mysql:host=$dbHost;port=$dbPort;dbname=$dbName;charset=utf8mb4",
                $dbUser,
                $dbPass,
                [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                ]
            );

            $sql = "-- PHP-based Database Backup\n";
            $sql .= "-- Database: $dbName\n";
            $sql .= "-- Date: " . date('Y-m-d H:i:s') . "\n\n";
            $sql .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

            // Get all tables
            $tables = $pdo->query("SHOW TABLES")->fetchAll(\PDO::FETCH_COLUMN);

            foreach ($tables as $table) {
                // Drop table if exists
                $sql .= "DROP TABLE IF EXISTS `$table`;\n\n";

                // Create table
                $createTable = $pdo->query("SHOW CREATE TABLE `$table`")->fetch();
                $sql .= $createTable['Create Table'] . ";\n\n";

                // Insert data
                $rows = $pdo->query("SELECT * FROM `$table`")->fetchAll();

                if (!empty($rows)) {
                    foreach ($rows as $row) {
                        $values = array_map(function($value) use ($pdo) {
                            return $value === null ? 'NULL' : $pdo->quote($value);
                        }, $row);

                        $sql .= "INSERT INTO `$table` VALUES (" . implode(', ', $values) . ");\n";
                    }
                    $sql .= "\n";
                }
            }

            $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";

            // Write to file
            if (file_put_contents($sqlFile, $sql) === false) {
                throw new \Exception('Failed to write SQL file');
            }

        } catch (\Exception $e) {
            throw new \Exception('PHP Backup failed: ' . $e->getMessage());
        }
    }

    /**
     * Add storage files to ZIP (images, etc)
     */
    protected function addStorageToZip(ZipArchive $zip)
    {
        $storageFolders = [
            public_path('storage/img-pegawai'),
            public_path('storage/img-aset'),
            public_path('storage/img-produk'),
        ];

        foreach ($storageFolders as $folder) {
            if (File::exists($folder)) {
                $files = File::allFiles($folder);
                foreach ($files as $file) {
                    $relativePath = 'storage/' . str_replace(public_path('storage/'), '', $file->getPathname());
                    $zip->addFile($file->getPathname(), $relativePath);
                }
            }
        }
    }

    /**
     * Download backup file
     */
    public function download($filename)
    {
        if ($response = $this->checkPermission('backup.manage', 'Anda tidak memiliki izin untuk mengunduh backup.')) {
            return $response;
        }

        $filePath = $this->backupPath . '/' . $filename;

        if (!File::exists($filePath)) {
            return redirect()
                ->route('backend.setting.backup')
                ->with('error', 'File backup tidak ditemukan.');
        }

        // Log activity
        ActivityLogger::log('download', 'backup', "Mengunduh backup: {$filename}");

        return response()->download($filePath);
    }

    /**
     * Delete backup file
     */
    public function destroy($filename)
    {
        if ($response = $this->checkPermission('backup.manage', 'Anda tidak memiliki izin untuk menghapus backup.')) {
            return $response;
        }

        $filePath = $this->backupPath . '/' . $filename;

        if (!File::exists($filePath)) {
            return redirect()
                ->route('backend.setting.backup')
                ->with('error', 'File backup tidak ditemukan.');
        }

        File::delete($filePath);

        // Log activity
        ActivityLogger::log('delete', 'backup', "Menghapus backup: {$filename}");

        return redirect()
            ->route('backend.setting.backup')
            ->with('success', 'Backup berhasil dihapus.');
    }

    /**
     * Restore from backup
     */
    public function restore(Request $request, $filename)
    {
        if ($response = $this->checkPermission('backup.manage', 'Anda tidak memiliki izin untuk melakukan restore database.')) {
            return $response;
        }

        try {
            $filePath = $this->backupPath . '/' . $filename;

            if (!File::exists($filePath)) {
                return redirect()
                    ->route('backend.setting.backup')
                    ->with('error', 'File backup tidak ditemukan.');
            }

            // 1. Create safety backup before restore
            $this->createSafetyBackup();

            // 2. Extract ZIP
            $extractPath = $this->backupPath . '/temp_restore';
            if (File::exists($extractPath)) {
                File::deleteDirectory($extractPath);
            }
            File::makeDirectory($extractPath, 0755, true);

            $zip = new ZipArchive();
            if ($zip->open($filePath) === TRUE) {
                $zip->extractTo($extractPath);
                $zip->close();
            } else {
                throw new \Exception('Gagal extract file backup.');
            }

            // 3. Restore Database
            $sqlFile = $extractPath . '/' . str_replace('.zip', '.sql', $filename);
            if (File::exists($sqlFile)) {
                $this->restoreDatabase($sqlFile);
            } else {
                throw new \Exception('File SQL tidak ditemukan dalam backup.');
            }

            // 4. Restore Storage Files (jika ada)
            $storageInBackup = $extractPath . '/storage';
            if (File::exists($storageInBackup)) {
                $this->restoreStorage($storageInBackup);
            }

            // Clean up
            File::deleteDirectory($extractPath);

            // Log activity
            ActivityLogger::log('restore', 'backup', "Restore database dari backup: {$filename}");

            return redirect()
                ->route('backend.setting.backup')
                ->with('success', 'Restore berhasil! Data telah dikembalikan.');

        } catch (\Exception $e) {
            return redirect()
                ->route('backend.setting.backup')
                ->with('error', 'Gagal restore: ' . $e->getMessage());
        }
    }

    /**
     * Create safety backup before restore
     */
    protected function createSafetyBackup()
    {
        $timestamp = date('Y-m-d_His');
        $backupName = "safety_backup_before_restore_{$timestamp}";

        $sqlFile = $this->backupPath . "/{$backupName}.sql";
        $this->backupDatabase($sqlFile);

        $zipFile = $this->backupPath . "/{$backupName}.zip";
        $zip = new ZipArchive();

        if ($zip->open($zipFile, ZipArchive::CREATE) === TRUE) {
            $zip->addFile($sqlFile, basename($sqlFile));
            $zip->close();
        }

        if (file_exists($sqlFile)) {
            unlink($sqlFile);
        }
    }

    /**
     * Restore database from SQL file
     */
    protected function restoreDatabase($sqlFile)
    {
        $dbHost = env('DB_HOST', '127.0.0.1');
        $dbName = env('DB_DATABASE');
        $dbUser = env('DB_USERNAME');
        $dbPass = env('DB_PASSWORD');

        // Try to find mysql
        $mysqlPath = $this->findMysql();

        if ($mysqlPath) {
            // Use mysql command
            $command = sprintf(
                '"%s" -h %s -u %s --password=%s %s < "%s" 2>&1',
                $mysqlPath,
                $dbHost,
                $dbUser,
                $dbPass,
                $dbName,
                $sqlFile
            );

            exec($command, $output, $returnVar);

            if ($returnVar === 0) {
                return; // Success
            }
        }

        // Fallback: PHP-based restore
        $this->restoreDatabasePHP($sqlFile);
    }

    /**
     * Find mysql executable
     */
    protected function findMysql()
    {
        // Common paths for mysql
        $paths = [
            'mysql', // If in PATH
            'C:\laragon\bin\mysql\mysql-8.0.30\bin\mysql.exe',
            'C:\laragon\bin\mysql\mysql-5.7.33\bin\mysql.exe',
            'C:\xampp\mysql\bin\mysql.exe',
            'C:\wamp64\bin\mysql\mysql8.0.27\bin\mysql.exe',
        ];

        // Check Laragon dynamic path
        if (file_exists('C:\laragon\bin\mysql')) {
            $mysqlDirs = glob('C:\laragon\bin\mysql\mysql-*');
            foreach ($mysqlDirs as $dir) {
                $paths[] = $dir . '\bin\mysql.exe';
            }
        }

        foreach ($paths as $path) {
            // Test if command exists
            exec("\"$path\" --version 2>NUL", $output, $returnVar);
            if ($returnVar === 0) {
                return $path;
            }
        }

        return null;
    }

    /**
     * PHP-based database restore (fallback)
     */
    protected function restoreDatabasePHP($sqlFile)
    {
        $dbHost = env('DB_HOST', '127.0.0.1');
        $dbName = env('DB_DATABASE');
        $dbUser = env('DB_USERNAME');
        $dbPass = env('DB_PASSWORD');
        $dbPort = env('DB_PORT', '3306');

        try {
            // Connect to database
            $pdo = new \PDO(
                "mysql:host=$dbHost;port=$dbPort;dbname=$dbName;charset=utf8mb4",
                $dbUser,
                $dbPass,
                [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                ]
            );

            // Read SQL file
            $sql = file_get_contents($sqlFile);

            if ($sql === false) {
                throw new \Exception('Failed to read SQL file');
            }

            // Disable foreign key checks
            $pdo->exec('SET FOREIGN_KEY_CHECKS=0');

            // Split and execute queries
            $queries = array_filter(array_map('trim', explode(';', $sql)));

            foreach ($queries as $query) {
                if (empty($query) || substr($query, 0, 2) === '--') {
                    continue;
                }

                try {
                    $pdo->exec($query);
                } catch (\PDOException $e) {
                    // Log error but continue (some queries might fail like DROP TABLE IF NOT EXISTS)
                    \Log::warning('Restore query failed: ' . $e->getMessage());
                }
            }

            // Enable foreign key checks
            $pdo->exec('SET FOREIGN_KEY_CHECKS=1');

        } catch (\Exception $e) {
            throw new \Exception('PHP Restore failed: ' . $e->getMessage());
        }
    }

    /**
     * Restore storage files
     */
    protected function restoreStorage($storageInBackup)
    {
        $targetPath = public_path('storage');

        // Copy files from backup to storage
        File::copyDirectory($storageInBackup, $targetPath);
    }

    /**
     * Upload and restore from uploaded file
     */
    public function upload(Request $request)
    {
        if ($response = $this->checkPermission('backup.manage', 'Anda tidak memiliki izin untuk mengupload file backup.')) {
            return $response;
        }

        $request->validate([
            'backup_file' => 'required|file|mimes:zip|max:512000', // max 500MB
        ], [
            'backup_file.required' => 'File backup harus dipilih.',
            'backup_file.mimes' => 'File harus berformat ZIP.',
            'backup_file.max' => 'Ukuran file maksimal 500MB.',
        ]);

        try {
            $file = $request->file('backup_file');
            $filename = 'uploaded_' . date('Y-m-d_His') . '.zip';
            $file->move($this->backupPath, $filename);

            // Log activity
            ActivityLogger::log('upload', 'backup', "Upload file backup: {$filename}");

            return redirect()
                ->route('backend.setting.backup')
                ->with('success', 'File backup berhasil diupload. Silakan restore dari daftar backup.');

        } catch (\Exception $e) {
            return redirect()
                ->route('backend.setting.backup')
                ->with('error', 'Gagal upload file: ' . $e->getMessage());
        }
    }

    /**
     * Format bytes to human readable
     */
    protected function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }
}
