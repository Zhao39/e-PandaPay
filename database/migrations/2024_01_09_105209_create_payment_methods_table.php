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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->decimal('minimum')->nullable();
            $table->decimal('maximum')->nullable();
            $table->decimal('charges_amount')->nullable();
            $table->string('charges_type')->default('percentage')->nullable();
            $table->string('duration')->nullable();
            $table->string('type')->nullable();
            $table->text('img_url')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('account_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('swift_code')->nullable();
            $table->text('wallet_address')->nullable();
            $table->text('coin', 20)->nullable();
            $table->string('barcode')->nullable();
            $table->string('network')->nullable();
            $table->string('methodtype')->nullable();
            $table->string('status')->nullable();
            $table->string('note')->nullable();
            $table->boolean('default_pay')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
