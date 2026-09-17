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
        // 1. Upgrade plans table
        Schema::table('plans', function (Blueprint $table) {
            if (!Schema::hasColumn('plans', 'slug')) {
                $table->string('slug')->nullable();
            }
            if (!Schema::hasColumn('plans', 'monthly_price')) {
                $table->decimal('monthly_price', 8, 2)->default(0.00);
            }
            if (!Schema::hasColumn('plans', 'annual_price')) {
                $table->decimal('annual_price', 8, 2)->default(0.00);
            }
            if (!Schema::hasColumn('plans', 'annual_discount_percent')) {
                $table->unsignedInteger('annual_discount_percent')->default(20);
            }
            if (!Schema::hasColumn('plans', 'currency')) {
                $table->string('currency', 10)->default('USD');
            }
            if (!Schema::hasColumn('plans', 'description')) {
                $table->text('description')->nullable();
            }
            if (!Schema::hasColumn('plans', 'features')) {
                $table->json('features')->nullable();
            }
            if (!Schema::hasColumn('plans', 'has_api_access')) {
                $table->boolean('has_api_access')->default(false);
            }
            if (!Schema::hasColumn('plans', 'has_custom_branding')) {
                $table->boolean('has_custom_branding')->default(false);
            }
            if (!Schema::hasColumn('plans', 'has_recurring_invoices')) {
                $table->boolean('has_recurring_invoices')->default(false);
            }
            if (!Schema::hasColumn('plans', 'has_priority_support')) {
                $table->boolean('has_priority_support')->default(false);
            }
            if (!Schema::hasColumn('plans', 'is_popular')) {
                $table->boolean('is_popular')->default(false);
            }
            if (!Schema::hasColumn('plans', 'is_active')) {
                $table->boolean('is_active')->default(true);
            }
            if (!Schema::hasColumn('plans', 'stripe_monthly_price_id')) {
                $table->string('stripe_monthly_price_id')->nullable();
            }
            if (!Schema::hasColumn('plans', 'stripe_annual_price_id')) {
                $table->string('stripe_annual_price_id')->nullable();
            }
        });

        // 2. Upgrade users table for subscription lifecycle
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'billing_cycle')) {
                $table->string('billing_cycle', 20)->default('monthly'); // monthly or annual
            }
            if (!Schema::hasColumn('users', 'subscription_status')) {
                $table->string('subscription_status', 30)->default('active'); // active, trialing, past_due, canceled, free
            }
            if (!Schema::hasColumn('users', 'stripe_customer_id')) {
                $table->string('stripe_customer_id')->nullable();
            }
            if (!Schema::hasColumn('users', 'stripe_subscription_id')) {
                $table->string('stripe_subscription_id')->nullable();
            }
            if (!Schema::hasColumn('users', 'current_period_starts_at')) {
                $table->timestamp('current_period_starts_at')->nullable();
            }
            if (!Schema::hasColumn('users', 'current_period_ends_at')) {
                $table->timestamp('current_period_ends_at')->nullable();
            }
            if (!Schema::hasColumn('users', 'canceled_at')) {
                $table->timestamp('canceled_at')->nullable();
            }
        });

        // 3. Upgrade payments table for receipts and gateway metadata
        Schema::table('payments', function (Blueprint $table) {
            if (!Schema::hasColumn('payments', 'billing_cycle')) {
                $table->string('billing_cycle', 20)->default('monthly');
            }
            if (!Schema::hasColumn('payments', 'currency')) {
                $table->string('currency', 10)->default('USD');
            }
            if (!Schema::hasColumn('payments', 'stripe_payment_intent_id')) {
                $table->string('stripe_payment_intent_id')->nullable();
            }
            if (!Schema::hasColumn('payments', 'stripe_session_id')) {
                $table->string('stripe_session_id')->nullable();
            }
            if (!Schema::hasColumn('payments', 'receipt_url')) {
                $table->string('receipt_url')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn([
                'slug', 'monthly_price', 'annual_price', 'annual_discount_percent',
                'currency', 'description', 'features', 'has_api_access',
                'has_custom_branding', 'has_recurring_invoices', 'has_priority_support',
                'is_popular', 'is_active', 'stripe_monthly_price_id', 'stripe_annual_price_id'
            ]);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'billing_cycle', 'subscription_status', 'stripe_customer_id',
                'stripe_subscription_id', 'current_period_starts_at',
                'current_period_ends_at', 'canceled_at'
            ]);
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn([
                'billing_cycle', 'currency', 'stripe_payment_intent_id',
                'stripe_session_id', 'receipt_url'
            ]);
        });
    }
};
