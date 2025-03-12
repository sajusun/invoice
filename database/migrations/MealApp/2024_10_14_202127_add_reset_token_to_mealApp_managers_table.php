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
        Schema::table('mealApp_managers', function (Blueprint $table) {
            if (!Schema::hasColumn('managers', 'reset_token')) {
                $table->string('reset_token')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mealApp_managers', function (Blueprint $table) {
            $table->dropColumn('reset_token');
        });
    }
};
