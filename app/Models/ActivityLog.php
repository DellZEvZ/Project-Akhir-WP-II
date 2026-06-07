<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $table = 'activity_logs';

    protected $fillable = [
        'user_id',
        'action_type',
        'module',
        'subject_type',
        'subject_id',
        'description',
        'properties',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'properties' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that performed the activity
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the subject model (polymorphic relationship)
     */
    public function subject()
    {
        return $this->morphTo();
    }

    /**
     * Get formatted action type
     */
    public function getActionBadgeAttribute()
    {
        $badges = [
            'create' => '<span class="badge badge-success">Create</span>',
            'update' => '<span class="badge badge-info">Update</span>',
            'delete' => '<span class="badge badge-danger">Delete</span>',
            'login' => '<span class="badge badge-primary">Login</span>',
            'logout' => '<span class="badge badge-secondary">Logout</span>',
            'view' => '<span class="badge badge-light">View</span>',
            'export' => '<span class="badge badge-warning">Export</span>',
        ];

        return $badges[$this->action_type] ?? '<span class="badge badge-secondary">' . ucfirst($this->action_type) . '</span>';
    }
}
