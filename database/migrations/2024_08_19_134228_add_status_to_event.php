<?php

use Database\Seeders\StatusSeeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('events', function (Blueprint $table) {
            $table->unsignedBigInteger('status_id')->default(1);
            $table->foreign('status_id')
                ->references('id')
                ->on('statuses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('events', function (Blueprint $table) {
            $table->dropForeign('events_status_id_foreign');
            $table->dropColumn('status_id');
        });
    }
};
