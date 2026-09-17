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
            $table->boolean('is_recurring')->default(false)->after('metadata')->index();
            $table->string('recurring_frequency', 20)->nullable()->after('is_recurring'); // weekly, monthly, quarterly, yearly
            $table->date('recurring_end_date')->nullable()->after('recurring_frequency');
            $table->date('last_recurring_at')->nullable()->after('recurring_end_date');
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
