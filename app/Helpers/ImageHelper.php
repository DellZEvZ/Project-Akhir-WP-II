<?php

namespace App\Helpers;

class ImageHelper
{
    /**
     * Upload dan resize gambar dengan GD Library
     *
     * @param mixed $file - File upload dari request
     * @param string $directory - Direktori tujuan (relatif dari public_path)
     * @param string $fileName - Nama file yang akan disimpan
     * @param int|null $width - Lebar target (null = tidak resize)
     * @param int|null $height - Tinggi target (null = maintain aspect ratio)
     * @return string - Nama file yang disimpan
     */
    public static function uploadAndResize($file, $directory, $fileName, $width = null, $height = null)
    {
        $destinationPath = public_path($directory);
        $extension = strtolower($file->getClientOriginalExtension());
        $image = null;

        // Tentukan metode pembuatan gambar berdasarkan ekstensi file
        switch ($extension) {
            case 'jpeg':
            case 'jpg':
                $image = imagecreatefromjpeg($file->getRealPath());
                break;
            case 'png':
                $image = @imagecreatefrompng($file->getRealPath());
                break;
            case 'gif':
                $image = imagecreatefromgif($file->getRealPath());
                break;
            default:
                throw new \Exception('Unsupported image type');
        }

        // Resize gambar jika lebar diset
        if ($width) {
            $oldWidth = imagesx($image);
            $oldHeight = imagesy($image);
            $aspectRatio = $oldWidth / $oldHeight;
            if (!$height) {
                $height = $width / $aspectRatio; // Hitung tinggi dengan mempertahankan aspek rasio
            }
            $newImage = imagecreatetruecolor($width, $height);
            imagecopyresampled($newImage, $image, 0, 0, 0, 0, $width, $height, $oldWidth, $oldHeight);
            imagedestroy($image);
            $image = $newImage;
        }

        // Simpan gambar dengan kualitas asli
        switch ($extension) {
            case 'jpeg':
            case 'jpg':
                imagejpeg($image, $destinationPath . '/' . $fileName);
                break;
            case 'png':
                imagepng($image, $destinationPath . '/' . $fileName);
                break;
            case 'gif':
                imagegif($image, $destinationPath . '/' . $fileName);
                break;
        }

        imagedestroy($image);
        return $fileName;
    }

    /**
     * Store image dengan resize otomatis ke 800px dan buat thumbnail 200x200
     *
     * @param mixed $file - File upload dari request
     * @param string $folder - Nama folder tujuan (img-pegawai, img-aset, dll)
     * @param string $filename - Nama file yang akan disimpan
     * @return array - Array berisi path original dan thumbnail
     */
    public static function storeImage($file, $folder, $filename)
    {
        $directory = 'storage/' . $folder . '/';
        $destinationPath = public_path($directory);

        // Buat direktori jika belum ada
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        // Buat direktori thumbs jika belum ada
        if (!file_exists($destinationPath . 'thumbs/')) {
            mkdir($destinationPath . 'thumbs/', 0755, true);
        }

        // Upload dan resize gambar asli ke 800px (maintain aspect ratio)
        self::uploadAndResize($file, $directory, $filename, 800, null);

        // Buat thumbnail 200x200
        self::uploadAndResize($file, $directory . 'thumbs/', $filename, 200, 200);

        return [
            'original' => $directory . $filename,
            'thumbnail' => $directory . 'thumbs/' . $filename
        ];
    }

    /**
     * Delete image beserta thumbnail
     *
     * @param string $imagePath - Path relatif gambar dari public_path
     * @param string $folder - Nama folder (img-pegawai, img-aset, dll)
     * @return bool
     */
    public static function deleteImage($imagePath, $folder)
    {
        if (!$imagePath) {
            return false;
        }

        $directory = public_path('storage/' . $folder . '/');

        // Hapus gambar original
        $originalPath = $directory . basename($imagePath);
        if (file_exists($originalPath)) {
            unlink($originalPath);
        }

        // Hapus thumbnail
        $thumbPath = $directory . 'thumbs/' . basename($imagePath);
        if (file_exists($thumbPath)) {
            unlink($thumbPath);
        }

        return true;
    }

    /**
     * Resize image dengan GD Library
     *
     * @param string $imagePath - Path gambar yang akan diresize
     * @param int $width - Lebar target
     * @param int|null $height - Tinggi target (null = maintain aspect ratio)
     * @return bool
     */
    public static function resizeImage($imagePath, $width, $height = null)
    {
        if (!file_exists($imagePath)) {
            return false;
        }

        $extension = strtolower(pathinfo($imagePath, PATHINFO_EXTENSION));
        $image = null;

        // Load gambar berdasarkan ekstensi
        switch ($extension) {
            case 'jpeg':
            case 'jpg':
                $image = imagecreatefromjpeg($imagePath);
                break;
            case 'png':
                $image = @imagecreatefrompng($imagePath);
                break;
            case 'gif':
                $image = imagecreatefromgif($imagePath);
                break;
            default:
                return false;
        }

        // Hitung dimensi baru
        $oldWidth = imagesx($image);
        $oldHeight = imagesy($image);
        $aspectRatio = $oldWidth / $oldHeight;

        if (!$height) {
            $height = $width / $aspectRatio;
        }

        // Resize
        $newImage = imagecreatetruecolor($width, $height);
        imagecopyresampled($newImage, $image, 0, 0, 0, 0, $width, $height, $oldWidth, $oldHeight);

        // Simpan gambar
        switch ($extension) {
            case 'jpeg':
            case 'jpg':
                imagejpeg($newImage, $imagePath);
                break;
            case 'png':
                imagepng($newImage, $imagePath);
                break;
            case 'gif':
                imagegif($newImage, $imagePath);
                break;
        }

        imagedestroy($image);
        imagedestroy($newImage);

        return true;
    }
}