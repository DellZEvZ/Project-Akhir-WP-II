<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Table name
     */
    protected $table = "user";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'email',
        'role',
        'status',
        'password',
        'hp',
        'foto',
        'last_login',
        'failed_login_attempts',
        'account_locked_until',
        'two_factor_enabled',
        'two_factor_secret',
        'remember_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
        'last_login' => 'datetime',
        'account_locked_until' => 'datetime',
        'two_factor_enabled' => 'boolean',
        'status' => 'boolean',
    ];

    /**
     * Get the roles assigned to the user.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id')
                    ->withPivot('assigned_by', 'assigned_at')
                    ->withTimestamps();
    }

    /**
     * Get the pegawai (employee) associated with the user.
     * One User has One Pegawai
     */
    public function pegawai()
    {
        return $this->hasOne(Pegawai::class, 'user_id', 'id');
    }

    /**
     * Check if user has a specific role.
     */
    public function hasRole(string|array $roles): bool
    {
        if (is_array($roles)) {
            return $this->roles()->whereIn('name', $roles)->exists();
        }

        return $this->roles()->where('name', $roles)->exists();
    }

    /**
     * Check if user has any of the given roles.
     */
    public function hasAnyRole(array $roles): bool
    {
        return $this->roles()->whereIn('name', $roles)->exists();
    }

    /**
     * Check if user has a specific permission.
     */
    public function hasPermission(string $permissionName): bool
    {
        return $this->roles()
                    ->with('permissions')
                    ->get()
                    ->pluck('permissions')
                    ->flatten()
                    ->where('name', $permissionName)
                    ->isNotEmpty();
    }

    /**
     * Assign a role to the user.
     */
    public function assignRole(string|int $role, int $assignedBy = null): void
    {
        $roleModel = is_numeric($role)
            ? Role::findOrFail($role)
            : Role::where('name', $role)->firstOrFail();

        $this->roles()->syncWithoutDetaching([
            $roleModel->id => [
                'assigned_by' => $assignedBy,
                'assigned_at' => now(),
            ]
        ]);
    }

    /**
     * Remove a role from the user.
     */
    public function removeRole(string|int $role): void
    {
        $roleModel = is_numeric($role)
            ? Role::findOrFail($role)
            : Role::where('name', $role)->firstOrFail();

        $this->roles()->detach($roleModel->id);
    }

    /**
     * Sync user roles (replace all existing roles).
     */
    public function syncRoles(array $roles, int $assignedBy = null): void
    {
        $roleIds = [];

        foreach ($roles as $role) {
            $roleModel = is_numeric($role)
                ? Role::findOrFail($role)
                : Role::where('name', $role)->firstOrFail();

            $roleIds[$roleModel->id] = [
                'assigned_by' => $assignedBy,
                'assigned_at' => now(),
            ];
        }

        $this->roles()->sync($roleIds);
    }

    /**
     * Get all permissions for the user (through roles).
     */
    public function getAllPermissions()
    {
        return $this->roles()
                    ->with('permissions')
                    ->get()
                    ->pluck('permissions')
                    ->flatten()
                    ->unique('id');
    }
}
