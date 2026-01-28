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
        Schema::create('coin_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->nullable()->constrained()->cascadeOnDelete();
            $table->string('txn_id')->nullable();
            $table->string('item_name')->nullable();
            $table->string('Item_number')->nullable();
            $table->string('amount_paid')->nullable();
            $table->string('user_plan')->nullable();
            $table->integer('user_tele_id')->nullable();
            $table->string('amount1')->nullable();
            $table->string('amount2')->nullable();
            $table->string('currency1')->nullable();
            $table->string('currency2')->nullable();
            $table->string('status')->nullable();
            $table->string('status_text')->nullable();
            $table->string('type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coin_payments', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('coin_payments');
    }
};
