<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barber extends Model
{
    use HasFactory;

    protected $table = 'barbers';
    protected $guarded = ['id'];

    protected $fillable = [
        'nama',
        'spesialisasi',
        'pengalaman_tahun',
        'no_hp',
        'foto',
        'status',
    ];

    public function isAktif(): bool
    {
        return $this->status === 'aktif';
    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    public function getPengalamanLabelAttribute(): string
    {
        return $this->pengalaman_tahun . ' tahun';
    }
}
