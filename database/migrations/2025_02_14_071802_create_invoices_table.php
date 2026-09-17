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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->nullable()->unique();
            $table->string('public_hash', 64)->nullable()->unique()->index();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->string('invoice_number')->unique();
            $table->date('invoice_date');
            $table->date('due_date')->nullable()->index();
            $table->json('items'); // snapshot of line items
            $table->decimal('subtotal', 20, 2)->default(0);
            $table->decimal('tax_amount', 20, 2)->default(0);
            $table->decimal('discount_amount', 20, 2)->default(0);
            $table->string('discount_type', 20)->default('fixed'); // fixed or percentage
            $table->decimal('total_amount', 20, 2);
            $table->decimal('paid_amount', 20, 2)->default(0);
            $table->string('currency', 10)->default('USD');
            $table->string('status', 30)->default('unpaid'); // unpaid, paid, partially_paid, overdue, canceled, draft
            $table->boolean('need_tax')->default(false);
            $table->text('notes')->nullable();
            $table->text('terms')->nullable();
            $table->json('metadata')->nullable(); // Developer custom attributes & ERP metadata
            $table->timestamps();

            // Compound indices for ultra-fast cursor pagination and financial queries
            $table->index(['user_id', 'created_at', 'id']);
            $table->index(['user_id', 'invoice_date', 'id']);
            $table->index(['user_id', 'status']);
            $table->index(['customer_id', 'status']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
