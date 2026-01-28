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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('customer_status')->nullable();
            $table->string('assigned_to')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->text('address')->nullable();
            $table->string('country')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('account_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('swift_code')->nullable();
            $table->string('btc_address')->nullable();
            $table->string('eth_address')->nullable();
            $table->string('ltc_address')->nullable();
            $table->string('usdt_address')->nullable();
            $table->decimal('account_bal')->default('0');
            $table->decimal('roi')->default('0');
            $table->decimal('bonus')->default('0');
            $table->decimal('ref_bonus')->default('0');
            $table->boolean('received_signup_bonus')->default(false);
            $table->boolean('trade_mode')->nullable()->default(true);
            $table->string('reffered_by')->nullable();
            $table->string('refferal_link')->nullable();
            $table->string('account_verify')->nullable();
            $table->string('status')->default('active');
            $table->string('withdrawal_otp')->nullable();
            $table->dateTime('withdrawal_otp_expired_at')->nullable();
            $table->boolean('can_withdraw')->default(true);
            $table->boolean('can_deposit')->default(true);
            $table->json('email_preference')->nullable();
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->boolean('is_admin')->default(false);
            $table->string('admin_type')->nullable();
            $table->dateTime('token_2fa_expiry')->nullable();
            $table->boolean('enable_2fa')->default(false);
            $table->string('admin_two_factor_code')->nullable();
            $table->boolean('pass_two_factor')->default(true);
            $table->string('timezone')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
