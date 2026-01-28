<?php

use App\Models\Plan;
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
        Schema::create('user_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Plan::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->decimal('amount')->nullable();
            $table->decimal('profit_earned')->nullable();
            $table->string('status')->default('active');
            $table->string('inv_duration')->nullable();
            $table->dateTime('expire_date')->nullable();
            $table->dateTime('activated_at')->nullable();
            $table->dateTime('next_growth')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_plans', function (Blueprint $table) {
            $table->dropForeign(['user_id', 'plan_id']);
        });
        Schema::dropIfExists('user_plans');
    }
};
