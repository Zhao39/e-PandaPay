<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'return_capital' => 'boolean',
        'should_cancel_plan' => 'boolean',
        'modules' => 'array',
        'themes' => 'array',
        'spa_mode' => 'boolean',
        'use_copytrade' => 'boolean',
        'show_progress_bar' => 'boolean',
        'use_api_price_for_swap' => 'boolean',
        'enable_trade_mode' => 'boolean',
        'enable_google_translate' => 'boolean',
        'enable_weekend_trade' => 'boolean',
        'enable_kyc' => 'boolean',
        'enable_kyc_registration' => 'boolean',
        'enable_withdrawal_otp' => 'boolean',
        'enable_email_verification' => 'boolean',
        'enable_social_login' => 'boolean',
        'enable_annoucement' => 'boolean',
        'use_terms' => 'boolean',
        'edit_email_verification_mail' => 'boolean',
        'send_welcome_email' => 'boolean',
        'receive_deposit_email' => 'boolean',
        'receive_withdrawal_email' => 'boolean',
        'receive_buyplan_email' => 'boolean',
        'receive_kyc_submission_email' => 'boolean',
        'receive_expired_plan_email' => 'boolean',
        'receive_trade_account_submission_email' => 'boolean',
        'receive_signal_subscribe_email' => 'boolean',
        'receive_buy_course_email' => 'boolean',
        'receive_payment_method_email' => 'boolean',
        'send_deposit_email' => 'boolean',
        'send_withdrawal_email' => 'boolean',
        'send_buyplan_email' => 'boolean',
        'send_expired_plan_email' => 'boolean',
        'send_trade_request_success_email' => 'boolean',
        'send_signal_subscribe_email' => 'boolean',
        'send_buy_course_email' => 'boolean',
        'send_kyc_status_email' => 'boolean',
        'send_roi_email' => 'boolean',
        'software_has_update' => 'boolean',
        'use_crypto_feature' => 'boolean',
        'use_transfer' => 'boolean',
        'schedule_system_backup' => 'boolean',
        'show_plans_on_home_page' => 'boolean',
        'site_in_maintenance_mode' => 'boolean',
        'coinpayment_to_wallet' => 'boolean',
        'password_validation_rules' => 'array',
    ];
}
