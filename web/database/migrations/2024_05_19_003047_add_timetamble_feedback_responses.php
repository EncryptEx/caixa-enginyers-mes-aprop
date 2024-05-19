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
        Schema::table('feedback_responses', function (Blueprint $table) {
            $table->integer('rating')->after('id');
            $table->integer('question')->after('rating');
            $table->integer('timetable')->after('question');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('feedback_responses', function (Blueprint $table) {
            $table->dropColumn('timetable');
            $table->dropColumn('question');
            $table->dropColumn('rating');
        });
    }
};
