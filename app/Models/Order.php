<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'customer_id', 'total_harga', 'status', 'jenis', 'barber_id',
        'tanggal_booking', 'jam_booking', 'catatan',
        'metode_bayar', 'kanal_bayar', 'status_bayar', 'bukti_bayar',
        'alamat_kirim', 'no_ref', 'dibayar_pada', 'hidden_at',
        'kota_tujuan_id', 'kota_tujuan_label', 'kurir', 'layanan_ongkir',
        'biaya_ongkir', 'estimasi_ongkir', 'total_berat',
    ];

    protected $casts = [
        'tanggal_booking' => 'date',
        'dibayar_pada'    => 'datetime',
        'hidden_at'       => 'datetime',
        'total_harga'     => 'decimal:2',
    ];

    public function getHasLayananAttribute(): bool
    {
        return $this->orderItems->whereNotNull('layanan_id')->isNotEmpty();
    }

    public function getHasProdukAttribute(): bool
    {
        return $this->orderItems->whereNotNull('produk_id')->isNotEmpty();
    }

    /**
     * Total akhir = total harga item + ongkos kirim (jika ada).
     * Untuk order jenis 'booking' (tanpa pengiriman), ongkir selalu 0.
     */
    public function getTotalAkhirAttribute()
    {
        return (float) $this->total_harga + (float) $this->biaya_ongkir;
    }

    public function getBiayaOngkirFormatAttribute(): string
    {
        return 'Rp ' . number_format($this->biaya_ongkir, 0, ',', '.');
    }

    public function barber()
    {
        return $this->belongsTo(Barber::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending'   => 'Menunggu Konfirmasi',
            'confirmed' => 'Dikonfirmasi',
            'done'      => 'Selesai',
            'batal'     => 'Dibatalkan',
            default     => $this->status,
        };
    }

    public function getStatusBayarLabelAttribute(): string
    {
        return match($this->status_bayar) {
            'belum'               => 'Belum Bayar',
            'menunggu_verifikasi' => 'Menunggu Verifikasi',
            'lunas'               => 'Lunas',
            default               => $this->status_bayar,
        };
    }
}
