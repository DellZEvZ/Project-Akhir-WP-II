<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('jenis', ['booking', 'produk'])->default('booking')->after('status');
            $table->enum('metode_bayar', ['transfer', 'cash', 'ewallet'])->nullable()->after('jenis');
            $table->enum('status_bayar', ['belum', 'menunggu_verifikasi', 'lunas'])->default('belum')->after('metode_bayar');
            $table->string('bukti_bayar')->nullable()->after('status_bayar');
            $table->text('alamat_kirim')->nullable()->after('bukti_bayar');
        });

        // Izinkan order_items menampung produk (layanan_id boleh null, tambah produk_id).
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['layanan_id']);
        });
        // Jadikan layanan_id nullable (untuk item produk yang tidak punya layanan).
        DB::statement('ALTER TABLE order_items MODIFY layanan_id BIGINT UNSIGNED NULL');
        Schema::table('order_items', function (Blueprint $table) {
            $table->foreign('layanan_id')->references('id')->on('layanans')->onDelete('cascade');
            $table->unsignedBigInteger('produk_id')->nullable()->after('layanan_id');
            $table->foreign('produk_id')->references('id')->on('produk')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['jenis', 'metode_bayar', 'status_bayar', 'bukti_bayar', 'alamat_kirim']);
        });
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn('produk_id');
        });
    }
};
