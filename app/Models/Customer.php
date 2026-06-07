<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Model
{
    use HasFactory, HasApiTokens;

    protected $table = 'customers';
    protected $guarded = ['id'];

    protected $fillable = [
        'nama', 'email', 'password', 'no_hp', 'alamat', 'foto', 'google_id',
    ];

    protected $hidden = ['password'];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
