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
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique()->comment('Permission name (slug format)');
            $table->string('display_name', 150)->comment('Human-readable permission name');
            $table->text('description')->nullable()->comment('Permission description');
            $table->string('module', 50)->nullable()->comment('Module category (kepegawaian, inventaris, etc.)');
            $table->timestamps();

            // Indexes
            $table->index('name');
            $table->index('module');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
