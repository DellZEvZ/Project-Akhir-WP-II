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
        Schema::create('user_roles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('user')->onDelete('cascade')->comment('FK to user table');
            $table->foreignId('role_id')->constrained('roles')->onDelete('cascade')->comment('FK to roles table');
            $table->foreignId('assigned_by')->nullable()->constrained('user')->onDelete('set null')->comment('User who assigned this role');
            $table->timestamp('assigned_at')->useCurrent()->comment('When the role was assigned');
            $table->timestamps();

            // Unique constraint to prevent duplicate role assignments
            $table->unique(['user_id', 'role_id'], 'unique_user_role');

            // Indexes
            $table->index('user_id');
            $table->index('role_id');
            $table->index('assigned_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_roles');
    }
};
