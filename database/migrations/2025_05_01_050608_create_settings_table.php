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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index();

            // Company details
            $table->string('company_name');
            $table->string('company_email')->nullable();
            $table->string('company_phone')->nullable();
            $table->text('company_address')->nullable();
            $table->string('company_logo')->nullable(); // store logo path

            // Invoice defaults
            $table->string('default_currency')->default('USD');
            $table->decimal('default_tax_rate', 5, 2)->nullable(); // e.g., 15.00%
            $table->boolean('show_tax_column')->default(false);
            $table->boolean('show_email_column')->default(false);
            $table->string('invoice_prefix')->default('INV-'); // e.g., "INV-"
            $table->integer('start_number')->default(1);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
