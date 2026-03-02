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
        Schema::table('dialogs', function (Blueprint $table) {
            // Добавляем поле final_grade после поля status
            // Оно может быть NULL (для незавершённых диалогов)
            $table->integer('final_grade')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dialogs', function (Blueprint $table) {
            // Удаляем поле при откате миграции
            $table->dropColumn('final_grade');
        });
    }
};