<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambahan kolom ongkos kirim (integrasi RajaOngkir/Komerce) — khusus
     * order jenis 'produk' yang dikirim, bukan diambil di tempat.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('kota_tujuan_id')->nullable()->after('alamat_kirim');
            $table->string('kota_tujuan_label')->nullable()->after('kota_tujuan_id');
            $table->string('kurir')->nullable()->after('kota_tujuan_label');
            $table->string('layanan_ongkir')->nullable()->after('kurir');
            $table->decimal('biaya_ongkir', 12, 2)->default(0)->after('layanan_ongkir');
            $table->string('estimasi_ongkir')->nullable()->after('biaya_ongkir');
            $table->float('total_berat')->nullable()->after('estimasi_ongkir');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'kota_tujuan_id',
                'kota_tujuan_label',
                'kurir',
                'layanan_ongkir',
                'biaya_ongkir',
                'estimasi_ongkir',
                'total_berat',
            ]);
        });
    }
};
