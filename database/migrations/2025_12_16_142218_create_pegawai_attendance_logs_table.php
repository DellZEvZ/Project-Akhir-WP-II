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
        Schema::create('pegawai_attendance_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawais')->cascadeOnDelete();
            $table->date('date');
            $table->timestamp('check_in_time')->nullable();
            $table->timestamp('check_out_time')->nullable();

            // Note: GPS coordinates not implemented in prototype version
            $table->string('check_in_photo')->nullable()->comment('Optional for prototype');
            $table->string('check_out_photo')->nullable()->comment('Optional for prototype');
            $table->boolean('check_in_verified')->default(false)->comment('Manual verification by admin');
            $table->boolean('check_out_verified')->default(false)->comment('Manual verification by admin');

            $table->enum('status', ['present', 'late', 'absent', 'leave', 'sick', 'holiday']);
            $table->integer('work_duration_minutes')->nullable();
            $table->integer('overtime_minutes')->default(0);
            $table->text('notes')->nullable();

            $table->foreignId('approved_by')->nullable()->constrained('user')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();

            // Indexes
            $table->unique(['pegawai_id', 'date']);
            $table->index('pegawai_id');
            $table->index('date');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai_attendance_logs');
    }
};
