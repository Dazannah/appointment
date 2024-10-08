<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('events', function (Blueprint $table) {
            $table->unsignedBigInteger('work_type_id');
            $table->foreign('work_type_id')
                ->references('id')
                ->on('work_types')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('events', function (Blueprint $table) {
            $table->dropForeign('events_work_type_id_foreign');
            $table->dropColumn('work_type_id');
        });
    }
};
