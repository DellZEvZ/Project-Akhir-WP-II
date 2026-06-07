<?php

namespace App\Traits;

trait HasPermissionCheck
{
    /**
     * Check if user has permission, redirect back with SweetAlert if not
     */
    protected function checkPermission(string $permission, string $message = null)
    {
        if (!auth()->user()->hasPermission($permission)) {
            $defaultMessage = 'Anda tidak memiliki izin untuk melakukan aksi ini.';

            return redirect()->back()
                ->with('error_permission_title', 'Akses Ditolak!')
                ->with('error_permission_message', $message ?? $defaultMessage);
        }

        return null;
    }
}
