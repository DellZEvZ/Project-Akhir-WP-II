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
        Schema::table('user', function (Blueprint $table) {
            // Security fields - add after updated_at
            $table->timestamp('last_login')->nullable()->after('updated_at')->comment('Last successful login timestamp');
            $table->integer('failed_login_attempts')->default(0)->after('last_login')->comment('Count of consecutive failed login attempts');
            $table->timestamp('account_locked_until')->nullable()->after('failed_login_attempts')->comment('Account lockout expiration time');
            $table->boolean('two_factor_enabled')->default(false)->after('account_locked_until')->comment('Two-factor authentication status');
            $table->string('two_factor_secret', 255)->nullable()->after('two_factor_enabled')->comment('Two-factor authentication secret');
            $table->string('remember_token', 100)->nullable()->after('two_factor_secret')->comment('Remember me token');

            // Indexes for performance
            $table->index('last_login');
            $table->index('account_locked_until');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user', function (Blueprint $table) {
            // Drop indexes first
            $table->dropIndex(['last_login']);
            $table->dropIndex(['account_locked_until']);

            // Drop columns
            $table->dropColumn([
                'last_login',
                'failed_login_attempts',
                'account_locked_until',
                'two_factor_enabled',
                'two_factor_secret',
                'remember_token'
            ]);
        });
    }
};
