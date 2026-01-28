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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name', 50)->nullable();
            $table->string('description');
            $table->string('site_title', 100)->nullable();
            $table->string('site_address', 50)->nullable();
            $table->string('admin_base_url')->nullable();
            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();
            $table->string('contact_email', 50)->nullable();
            $table->string('currency', 10)->nullable();
            $table->string('s_currency', 10)->nullable();
            $table->string('capt_secret')->nullable();
            $table->string('capt_sitekey')->nullable();
            $table->string('payment_mode')->nullable();
            $table->string('location')->nullable();
            $table->string('s_s_k')->nullable();
            $table->string('s_p_k')->nullable();
            $table->string('pp_cs')->nullable();
            $table->string('pp_ci')->nullable();
            $table->string('pp_app_id')->nullable();
            $table->string('keywords')->nullable();
            $table->boolean('enable_trade_mode')->default(true);
            $table->boolean('enable_google_translate')->default(false);
            $table->boolean('enable_weekend_trade')->default(false);
            $table->string('timezone', 50)->nullable();
            $table->string('mail_server')->nullable();
            $table->string('emailfrom')->nullable();
            $table->string('emailfromname')->nullable();
            $table->string('smtp_host')->nullable();
            $table->string('smtp_port', 8)->nullable();
            $table->string('smtp_encrypt', 10)->nullable();
            $table->string('smtp_user')->nullable();
            $table->string('smtp_password')->nullable();
            $table->string('google_secret')->nullable();
            $table->string('google_id')->nullable();
            $table->string('google_redirect')->nullable();
            $table->string('referral_commission', 5)->nullable();
            $table->string('referral_commission1', 5)->nullable();
            $table->string('referral_commission2', 5)->nullable();
            $table->string('referral_commission3', 5)->nullable();
            $table->string('referral_commission4', 5)->nullable();
            $table->string('referral_commission5', 5)->nullable();
            $table->decimal('signup_bonus')->nullable();
            $table->decimal('deposit_bonus')->nullable();
            $table->text('live_chat')->nullable();
            $table->boolean('enable_kyc')->default(false);
            $table->boolean('enable_kyc_registration')->default(false);
            $table->boolean('enable_withdrawal_otp')->default(true);
            $table->boolean('enable_email_verification')->default(true);
            $table->boolean('enable_social_login')->default(false);
            $table->string('withdrawal_option')->nullable();
            $table->string('deposit_option')->nullable();
            $table->string('auto_merchant_option')->nullable();
            $table->boolean('coinpayment_to_wallet')->default(true);
            $table->string('auto_deposit_merchant')->nullable();
            $table->boolean('enable_annoucement')->default(false);
            $table->string('subscription_service')->nullable();
            $table->string('captcha')->nullable();
            $table->boolean('return_capital')->default(true);
            $table->boolean('should_cancel_plan')->default(false);
            $table->string('subscription_type', 50)->nullable();
            $table->decimal('percentage_fee')->nullable();
            $table->boolean('use_copytrade')->default(true);
            $table->boolean('use_terms')->default(true);
            $table->string('commission_type', 50)->nullable();
            $table->string('billing_period', 50)->nullable();
            $table->decimal('commission_fee')->nullable();
            $table->decimal('monthlyfee')->nullable();
            $table->decimal('quarterlyfee')->nullable();
            $table->decimal('yearlyfee')->nullable();
            $table->json('modules')->nullable();
            $table->boolean('send_welcome_email')->default(true);
            $table->boolean('edit_email_verification_mail')->default(false);
            $table->string('redirect_url')->nullable();
            $table->string('website_theme')->nullable();
            $table->string('referral_proffit_from')->nullable();
            $table->string('theme')->nullable();
            $table->string('ib_link')->nullable();
            $table->json('themes')->nullable();
            $table->string('credit_card_provider', 50)->nullable();
            $table->string('deduction_option')->nullable();
            $table->text('welcome_message')->nullable();
            $table->string('merchant_key')->nullable();
            $table->string('paystack_public_key')->nullable();
            $table->string('paystack_secret_key')->nullable();
            $table->string('paystack_url')->nullable();
            $table->string('paystack_email')->nullable();
            $table->boolean('use_crypto_feature')->default(true);
            $table->decimal('crypto_charges')->nullable();
            $table->decimal('currency_rate')->nullable();
            $table->decimal('minamt')->nullable();
            $table->boolean('use_transfer')->default(true);
            $table->decimal('min_transfer')->nullable();
            $table->string('purchase_code')->nullable();
            $table->string('old_version')->default(6);
            $table->decimal('transfer_charges')->nullable();
            $table->string('binance_secret_key')->nullable();
            $table->string('binance_api_key')->nullable();
            $table->string('flw_secret_hash')->nullable();
            $table->string('flw_secret_key')->nullable();
            $table->string('flw_public_key')->nullable();
            $table->string('local_currency')->nullable();
            $table->string('telegram_bot_api')->nullable();
            $table->string('cp_p_key')->nullable();
            $table->string('cp_pv_key')->nullable();
            $table->string('cp_m_id')->nullable();
            $table->string('cp_ipn_secret')->nullable();
            $table->string('cp_debug_email')->nullable();
            $table->json('password_validation_rules')->nullable();
            $table->boolean('spa_mode')->default(false);
            $table->string('progress_bar_color', 10)->default('#2299dd');
            $table->boolean('use_api_price_for_swap')->default(true);
            $table->decimal('swap_fee')->nullable();
            $table->boolean('site_in_maintenance_mode')->default(false);
            $table->text('maintenance_mode_token')->nullable();
            $table->string('home_theme', 7)->default('Home1')->nullable();
            $table->boolean('show_plans_on_home_page')->default(true);
            $table->string('facebook_social_link')->nullable();
            $table->string('x_social_link')->nullable();
            $table->string('instagram_social_link')->nullable();
            $table->string('coinbase_apikey')->nullable();
            $table->string('coinbase_apiversion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};