<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aset extends Model
{
    use HasFactory;

    public $timestamps = true;
    protected $table = "asets";
    protected $guarded = ['id'];

    protected $fillable = [
        'nama_aset',
        'kode_aset',
        'deskripsi',
        'kategori',
        'supplier',
        'tanggal_pembelian',
        'harga_perolehan',
        'nilai_saat_ini',
        'status_aset',
        'lokasi',
        'foto_aset',
        'last_maintenance',
        'next_maintenance'
    ];

    protected $casts = [
        'tanggal_pembelian' => 'date',
        'last_maintenance' => 'date',
        'next_maintenance' => 'date',
        'harga_perolehan' => 'decimal:2',
        'nilai_saat_ini' => 'decimal:2',
    ];

    /**
     * Method untuk cek status aset
     */
    public function isAktif()
    {
        return $this->status_aset === 'aktif';
    }

    public function isRusak()
    {
        return $this->status_aset === 'rusak';
    }

    public function isHilang()
    {
        return $this->status_aset === 'hilang';
    }

    public function isDijual()
    {
        return $this->status_aset === 'dijual';
    }

    /**
     * Scope untuk filter aset aktif
     */
    public function scopeAktif($query)
    {
        return $query->where('status_aset', 'aktif');
    }

    /**
     * Scope untuk filter aset rusak
     */
    public function scopeRusak($query)
    {
        return $query->where('status_aset', 'rusak');
    }

    /**
     * Scope untuk filter aset hilang
     */
    public function scopeHilang($query)
    {
        return $query->where('status_aset', 'hilang');
    }

    /**
     * Scope untuk filter aset dijual
     */
    public function scopeDijual($query)
    {
        return $query->where('status_aset', 'dijual');
    }

    /**
     * Scope untuk filter berdasarkan kategori
     */
    public function scopeKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    /**
     * Scope untuk filter berdasarkan lokasi
     */
    public function scopeLokasi($query, $lokasi)
    {
        return $query->where('lokasi', $lokasi);
    }

    /**
     * Accessor untuk format harga perolehan
     */
    public function getHargaPerolehanFormatAttribute()
    {
        return 'Rp ' . number_format($this->harga_perolehan, 0, ',', '.');
    }

    /**
     * Accessor untuk format nilai saat ini
     */
    public function getNilaiSaatIniFormatAttribute()
    {
        return 'Rp ' . number_format($this->nilai_saat_ini, 0, ',', '.');
    }

    /**
     * Accessor untuk umur aset (dalam tahun)
     */
    public function getUmurAsetAttribute()
    {
        if (!$this->tanggal_pembelian) {
            return null;
        }
        return $this->tanggal_pembelian->diffInYears(now());
    }

    /**
     * Accessor untuk depresiasi (penurunan nilai)
     */
    public function getDepresiasiAttribute()
    {
        return $this->harga_perolehan - $this->nilai_saat_ini;
    }

    /**
     * Accessor untuk persentase depresiasi
     */
    public function getPersentaseDepresiasiAttribute()
    {
        if ($this->harga_perolehan == 0) {
            return 0;
        }
        return round(($this->depresiasi / $this->harga_perolehan) * 100, 2);
    }

    /**
     * Cek apakah aset perlu maintenance
     */
    public function needsMaintenance()
    {
        if (!$this->next_maintenance) {
            return false;
        }
        return $this->next_maintenance->isPast() || $this->next_maintenance->isToday();
    }

    /**
     * Cek apakah maintenance akan segera jatuh tempo (dalam 7 hari)
     */
    public function maintenanceUpcoming()
    {
        if (!$this->next_maintenance) {
            return false;
        }
        return $this->next_maintenance->between(now(), now()->addDays(7));
    }
}
