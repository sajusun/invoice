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
        Schema::table('invoices', function (Blueprint $table) {
            if (!Schema::hasColumn('invoices', 'metadata')) {
                $table->json('metadata')->nullable();
            }
            if (!Schema::hasColumn('invoices', 'is_recurring')) {
                $table->boolean('is_recurring')->default(false)->index();
            }
            if (!Schema::hasColumn('invoices', 'recurring_frequency')) {
                $table->string('recurring_frequency', 20)->nullable();
            }
            if (!Schema::hasColumn('invoices', 'recurring_end_date')) {
                $table->date('recurring_end_date')->nullable();
            }
            if (!Schema::hasColumn('invoices', 'last_recurring_at')) {
                $table->date('last_recurring_at')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn(['is_recurring', 'recurring_frequency', 'recurring_end_date', 'last_recurring_at']);
        });
    }
};
