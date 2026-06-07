<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    use HasFactory;

    protected $table = 'layanans';
    protected $guarded = ['id'];

    protected $fillable = [
        'nama_layanan',
        'deskripsi',
        'harga',
        'durasi_menit',
        'foto',
        'status',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
    ];

    public function isAktif(): bool
    {
        return $this->status === 'aktif';
    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    public function getHargaFormatAttribute(): string
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }

    public function getDurasiLabelAttribute(): string
    {
        return $this->durasi_menit . ' menit';
    }
}
