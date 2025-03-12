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
        Schema::create('mealApp_expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('manager_id')->constrained('managers')->references('id')->onDelete('cascade');
            $table->unsignedBigInteger('amount');
            $table->string('description');
            $table->date('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mealApp_expenses');
    }
};
