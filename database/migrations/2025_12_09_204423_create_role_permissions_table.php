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
        Schema::create('role_permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->constrained('roles')->onDelete('cascade')->comment('FK to roles table');
            $table->foreignId('permission_id')->constrained('permissions')->onDelete('cascade')->comment('FK to permissions table');
            $table->timestamps();

            // Unique constraint to prevent duplicate assignments
            $table->unique(['role_id', 'permission_id'], 'unique_role_permission');

            // Indexes
            $table->index('role_id');
            $table->index('permission_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_permissions');
    }
};
