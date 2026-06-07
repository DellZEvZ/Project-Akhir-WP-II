<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('asets', function (Blueprint $table) {
            $table->id();
            $table->string('nama_aset');
            $table->string('kode_aset')->unique();
            $table->text('deskripsi')->nullable();
            $table->string('kategori');
            $table->string('supplier')->nullable();
            $table->date('tanggal_pembelian');
            $table->decimal('harga_perolehan', 15, 2)->default(0);
            $table->decimal('nilai_saat_ini', 15, 2)->default(0);
            $table->enum('status_aset', ['aktif', 'rusak', 'hilang', 'dijual'])->default('aktif');
            $table->string('lokasi')->nullable();
            $table->string('foto_aset')->nullable();
            $table->date('last_maintenance')->nullable();
            $table->date('next_maintenance')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asets');
    }
};
