<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('penalty_fees', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->unsignedBigInteger('event_id');
            $table->foreign('event_id')
                ->references('id')
                ->on('events');

            $table->unsignedBigInteger('penalty_fee_status_id')->default(1);
            $table->foreign('penalty_fee_status_id')
                ->references('id')
                ->on('penalty_fee_statuses');

            $table->unsignedBigInteger('penalty_fee_price_id')->default(1);
            $table->foreign('penalty_fee_price_id')
                ->references('id')
                ->on('penalty_fee_prices');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('penalty_fees');
    }
};
