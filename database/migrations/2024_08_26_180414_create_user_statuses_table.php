<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('user_statuses', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('name');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('user_status_id')->default(1);
            $table->foreign('user_status_id')
                ->references('id')
                ->on('user_statuses')
                ->onDelete('cascade');

            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_user_status_id_foreign');
            $table->dropColumn('user_status_id');
        });

        Schema::dropIfExists('user_statuses');
    }
};
