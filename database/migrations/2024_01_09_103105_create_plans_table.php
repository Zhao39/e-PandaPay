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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->decimal('price')->nullable();
            $table->decimal('min_price')->nullable();
            $table->decimal('max_price')->nullable();
            $table->decimal('min_return')->nullable();
            $table->decimal('max_return')->nullable();
            $table->decimal('bonus')->nullable();
            $table->decimal('expected_return')->nullable();
            $table->string('type')->nullable();
            $table->string('increment_interval');
            $table->string('increment_type');
            $table->string('increment_amount');
            $table->string('duration');
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
