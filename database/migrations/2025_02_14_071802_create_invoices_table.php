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
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('customer_id');
            $table->string('invoice_number')->unique();
            $table->date('invoice_date');
            $table->json('items');
            $table->decimal('paid_amount');
            $table->decimal('total_amount', 10, 2);
            $table->string('status')->default('pending'); // pending, paid, canceled
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
        });

//        Schema::create('invoice_items', function (Blueprint $table) {
//            $table->id();
//            $table->unsignedBigInteger('invoice_id');
//            $table->string('description');
//            $table->integer('quantity');
//            $table->decimal('unit_price', 10, 2);
//            $table->decimal('advance', 10, 2);
//            $table->decimal('total_price', 10, 2);
//            $table->timestamps();
//
//            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
//        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
