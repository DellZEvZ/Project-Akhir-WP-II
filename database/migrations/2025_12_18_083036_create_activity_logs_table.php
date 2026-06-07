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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // User yang melakukan aksi (nullable untuk guest/system)
            $table->string('action_type', 50); // create, update, delete, login, logout, view, export
            $table->string('module', 50); // pegawai, aset, user, produk, kategori, permission, role, dll
            $table->string('subject_type', 100)->nullable(); // Model class (App\Models\Pegawai, dll)
            $table->unsignedBigInteger('subject_id')->nullable(); // ID record yang di-aksi
            $table->text('description'); // Deskripsi aktivitas (contoh: "Menambah pegawai baru: John Doe")
            $table->json('properties')->nullable(); // Data sebelum dan sesudah perubahan
            $table->string('ip_address', 45)->nullable(); // IP address user
            $table->string('user_agent', 255)->nullable(); // Browser/device info
            $table->timestamps();

            // Indexes
            $table->index('user_id');
            $table->index('action_type');
            $table->index('module');
            $table->index('created_at');

            // Foreign key
            $table->foreign('user_id')->references('id')->on('user')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
