<?php

namespace App\Helpers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLogger
{
    /**
     * Log an activity
     *
     * @param string $actionType (create, update, delete, login, logout, view, export)
     * @param string $module (pegawai, aset, user, produk, kategori, permission, role, dll)
     * @param string $description
     * @param mixed $subject (Model instance or null)
     * @param array $properties (additional data, old and new values, etc)
     * @return ActivityLog
     */
    public static function log(
        string $actionType,
        string $module,
        string $description,
        $subject = null,
        array $properties = []
    ) {
        $data = [
            'user_id' => Auth::id(),
            'action_type' => $actionType,
            'module' => $module,
            'description' => $description,
            'properties' => $properties,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ];

        // If subject is a model, add subject info
        if ($subject && is_object($subject)) {
            $data['subject_type'] = get_class($subject);
            $data['subject_id'] = $subject->id ?? null;
        }

        return ActivityLog::create($data);
    }

    /**
     * Log create action
     */
    public static function created(string $module, string $name, $subject = null, array $properties = [])
    {
        return self::log(
            'create',
            $module,
            "Menambahkan {$module} baru: {$name}",
            $subject,
            $properties
        );
    }

    /**
     * Log update action
     */
    public static function updated(string $module, string $name, $subject = null, array $old = [], array $new = [])
    {
        $properties = [
            'old' => $old,
            'new' => $new,
        ];

        return self::log(
            'update',
            $module,
            "Mengubah data {$module}: {$name}",
            $subject,
            $properties
        );
    }

    /**
     * Log delete action
     */
    public static function deleted(string $module, string $name, $subject = null, array $properties = [])
    {
        return self::log(
            'delete',
            $module,
            "Menghapus {$module}: {$name}",
            $subject,
            $properties
        );
    }

    /**
     * Log login action
     */
    public static function login(string $userName)
    {
        return self::log(
            'login',
            'auth',
            "User login: {$userName}"
        );
    }

    /**
     * Log logout action
     */
    public static function logout(string $userName)
    {
        return self::log(
            'logout',
            'auth',
            "User logout: {$userName}"
        );
    }

    /**
     * Log view action
     */
    public static function viewed(string $module, string $name, $subject = null)
    {
        return self::log(
            'view',
            $module,
            "Melihat {$module}: {$name}",
            $subject
        );
    }

    /**
     * Log export action
     */
    public static function exported(string $module, string $format = 'PDF')
    {
        return self::log(
            'export',
            $module,
            "Mengekspor laporan {$module} ke {$format}"
        );
    }

    /**
     * Log permission update action
     */
    public static function permissionUpdated(string $roleName, array $permissions)
    {
        return self::log(
            'update',
            'permission',
            "Mengubah permission role: {$roleName}",
            null,
            [
                'role' => $roleName,
                'permissions' => $permissions,
            ]
        );
    }
}
