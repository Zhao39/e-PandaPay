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
            $table->after('modules', function (Blueprint $table) {
                $table->string('install_type', 15)->default('Main-Domain')->nullable();
                $table->boolean('receive_deposit_email')->default(true);
                $table->boolean('receive_withdrawal_email')->default(true);
                $table->boolean('receive_buyplan_email')->default(true);
                $table->boolean('receive_kyc_submission_email')->default(true);
                $table->boolean('receive_expired_plan_email')->default(true);
                $table->boolean('receive_trade_account_submission_email')->default(true);
                $table->boolean('receive_signal_subscribe_email')->default(true);
                $table->boolean('receive_buy_course_email')->default(true);
                $table->boolean('receive_payment_method_email')->default(true);
                $table->boolean('send_deposit_email')->default(true);
                $table->boolean('send_withdrawal_email')->default(true);
                $table->boolean('send_buyplan_email')->default(true);
                $table->boolean('send_expired_plan_email')->default(true);
                $table->boolean('send_trade_request_success_email')->default(true);
                $table->boolean('send_signal_subscribe_email')->default(true);
                $table->boolean('send_buy_course_email')->default(true);
                $table->boolean('send_kyc_status_email')->default(true);
                $table->boolean('send_roi_email')->default(true);
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'install_type',
                'receive_deposit_email',
                'receive_withdrawal_email',
                'receive_buyplan_email',
                'receive_expired_plan_email',
                'receive_trade_account_submission_email',
                'receive_signal_subscribe_email',
                'receive_buy_course_email',
                'receive_kyc_submission_email',
                'receive_payment_method_email',
                'receive_deposit_email',
                'send_deposit_email',
                'send_withdrawal_email',
                'send_buyplan_email',
                'send_expired_plan_email',
                'send_trade_request_success_email',
                'send_signal_subscribe_email',
                'send_buy_course_email',
                'send_kyc_status_email',
                'send_roi_email',
            ]);
        });
    }
};
