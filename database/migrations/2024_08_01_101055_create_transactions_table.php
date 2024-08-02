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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('from_account_id')->nullable();
            $table->foreign('from_account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->unsignedBigInteger('to_account_id')->nullable();
            $table->foreign('to_account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->decimal('amount', 15, 2)->nullable();
            $table->decimal('balance', 15, 2)->nullable();
            $table->decimal('exchange_amount',15, 2)->nullable();
            $table->text('description')->nullable();
            $table->timestamp('transaction_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
