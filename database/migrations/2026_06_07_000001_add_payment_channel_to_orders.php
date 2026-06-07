<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('kanal_bayar')->nullable()->after('metode_bayar');   // mis. BCA, OVO, GoPay
            $table->string('no_ref')->nullable()->after('bukti_bayar');          // nomor referensi struk
            $table->timestamp('dibayar_pada')->nullable()->after('no_ref');      // waktu pembayaran (simulasi)
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['kanal_bayar', 'no_ref', 'dibayar_pada']);
        });
    }
};
