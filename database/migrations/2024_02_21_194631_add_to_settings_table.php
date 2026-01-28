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
        Schema::table('settings', function (Blueprint $table) {
            $table->integer('admin_dashboard_logo_size')->default(20)->after('swap_fee');
            $table->integer('website_logo_size')->nullable()->after('admin_dashboard_logo_size');
            $table->integer('auth_pages_logo_size')->default(20)->after('website_logo_size');
            $table->integer('user_dashboard_logo_size')->default(20)->after('admin_dashboard_logo_size');
            $table->integer('delete_records_older_than_days')->default(20)->after('user_dashboard_logo_size');
            $table->boolean('schedule_system_backup')->default(false)->after('delete_records_older_than_days');
            $table->integer('keep_all_backups_for_days')->default(7)->after('schedule_system_backup');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['admin_dashboard_logo_size', 'user_dashboard_logo_size', 'delete_records_older_than_days', 'schedule_system_backup', 'keep_all_backups_for_days', 'auth_pages_logo_size', 'website_logo_size']);
        });
    }
};
