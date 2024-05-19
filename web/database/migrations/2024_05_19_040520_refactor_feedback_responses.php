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
            $table->renameColumn('question', 'time_increment');
            $table->string('municipi')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('feedback_responses', function (Blueprint $table) {
            $table->renameColumn('time_increment', 'question');
            $table->dropColumn('municipi');
        });
    }
};
