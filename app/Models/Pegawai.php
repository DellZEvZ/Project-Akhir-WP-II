<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    public $timestamps = true;
    protected $table = "pegawais";
    protected $guarded = ['id'];

    protected $fillable = [
        'nama',
        'email',
        'no_hp',
        'alamat',
        'jabatan',
        'departemen',
        'status_pegawai',
        'tanggal_masuk',
        'tanggal_lahir',
        'jenis_kelamin',
        'foto',
        'user_id',
        'gaji_pokok'
    ];

    protected $casts = [
        'tanggal_masuk' => 'date',
        'tanggal_lahir' => 'date',
        'gaji_pokok' => 'decimal:2',
    ];

    /**
     * Relationship dengan User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Method untuk cek status pegawai
     */
    public function isAktif()
    {
        return $this->status_pegawai === 'aktif';
    }

    public function isCuti()
    {
        return $this->status_pegawai === 'cuti';
    }

    public function isResign()
    {
        return $this->status_pegawai === 'resign';
    }

    /**
     * Scope untuk filter pegawai aktif
     */
    public function scopeAktif($query)
    {
        return $query->where('status_pegawai', 'aktif');
    }

    /**
     * Scope untuk filter pegawai cuti
     */
    public function scopeCuti($query)
    {
        return $query->where('status_pegawai', 'cuti');
    }

    /**
     * Scope untuk filter pegawai resign
     */
    public function scopeResign($query)
    {
        return $query->where('status_pegawai', 'resign');
    }

    /**
     * Scope untuk filter berdasarkan departemen
     */
    public function scopeDepartemen($query, $departemen)
    {
        return $query->where('departemen', $departemen);
    }

    /**
     * Accessor untuk format gaji
     */
    public function getGajiFormatAttribute()
    {
        return 'Rp ' . number_format($this->gaji_pokok, 0, ',', '.');
    }

    /**
     * Accessor untuk umur pegawai
     */
    public function getUmurAttribute()
    {
        if (!$this->tanggal_lahir) {
            return null;
        }
        return $this->tanggal_lahir->age;
    }

    /**
     * Accessor untuk lama bekerja (dalam tahun)
     */
    public function getLamaKerjaAttribute()
    {
        if (!$this->tanggal_masuk) {
            return null;
        }
        return $this->tanggal_masuk->diffInYears(now());
    }
}
