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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('company_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone');
            $table->string('tax_id')->nullable();
            $table->text('address')->nullable();
            $table->text('notes')->nullable();
            $table->json('metadata')->nullable(); // Developer custom attributes
            $table->timestamps();

            // Compound indices for fast search and cursor pagination
            $table->index(['user_id', 'created_at', 'id']);
            $table->index(['user_id', 'email']);
            $table->index(['user_id', 'phone']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
