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
        Schema::table('reviewables', function (Blueprint $table) {
            $table->integer('tutorial_order')->unsigned()->nullable();
            $table->text('tutorial_info')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviewables', function (Blueprint $table) {
            $table->dropColumn('tutorial_order', 'tutorial_info');
        });
    }
};
