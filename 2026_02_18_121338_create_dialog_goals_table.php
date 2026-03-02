<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dialog_goals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dialog_id')->constrained()->onDelete('cascade');
            $table->text('description');
            $table->boolean('is_completed')->default(false);
            $table->boolean('is_default')->default(false); // Предустановленная цель?
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dialog_goals');
    }
};