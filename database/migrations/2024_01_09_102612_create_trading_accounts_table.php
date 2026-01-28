<?php

use App\Models\User;
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
        Schema::create('trading_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->nullable()->constrained()->cascadeOnDelete();
            $table->text('meta_account_id')->nullable();
            $table->string('login')->nullable();
            $table->string('name')->nullable();
            $table->text('password')->nullable();
            $table->string('platform')->nullable();
            $table->string('account_type')->nullable();
            $table->string('currency')->nullable();
            $table->string('leverage')->nullable();
            $table->string('server')->nullable();
            $table->string('options')->nullable();
            $table->string('duration')->nullable();
            $table->string('status')->nullable();
            $table->boolean('copying_trade')->default(false);
            $table->boolean('is_deployed')->default(false);
            $table->string('deployment_status')->nullable();
            $table->string('provider')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->dateTime('expired_at')->nullable();
            $table->dateTime('reminded_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trading_accounts', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('trading_accounts');
    }
};
