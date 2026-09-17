<?php

namespace App\Console\Commands;

use App\Models\Invoice;
use App\Services\InvoiceService;
use App\Services\WebhookDispatcherService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class GenerateRecurringInvoices extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'invoices:generate-recurring';

    /**
     * The console command description.
     */
    protected $description = 'Generate new invoices for active recurring invoice schedules.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Scanning recurring invoices schedule...');

        $recurringInvoices = Invoice::with(['user', 'customer'])
            ->where('is_recurring', true)
            ->where(function ($query) {
                $query->whereNull('recurring_end_date')
                    ->orWhere('recurring_end_date', '>=', now()->startOfDay());
            })
            ->get();

        $count = 0;
        $webhookService = app(WebhookDispatcherService::class);

        foreach ($recurringInvoices as $parentInvoice) {
            if (!$this->shouldGenerateToday($parentInvoice)) {
                continue;
            }

            try {
                $newInvoice = InvoiceService::duplicateInvoice($parentInvoice);
                $newInvoice->invoice_date = now()->format('Y-m-d');
                $newInvoice->due_date = now()->addDays(30)->format('Y-m-d');
                $newInvoice->status = 'unpaid';
                $newInvoice->is_recurring = false; // Generated clone is not the master schedule
                $newInvoice->save();

                // Update parent last recurring timestamp
                $parentInvoice->last_recurring_at = now()->toDateString();
                $parentInvoice->save();

                $count++;
                $this->line("  -> Generated recurring Invoice #{$newInvoice->invoice_number} from parent #{$parentInvoice->invoice_number}.");

                // Dispatch webhook
                try {
                    if ($parentInvoice->user) {
                        $webhookService->dispatchForUser($parentInvoice->user, 'invoice.created', [
                            'invoice_id'        => $newInvoice->id,
                            'invoice_number'    => $newInvoice->invoice_number,
                            'parent_invoice_id' => $parentInvoice->id,
                            'total_amount'      => $newInvoice->total_amount,
                            'status'            => $newInvoice->status,
                        ]);
                    }
                } catch (\Throwable) {
                }
            } catch (\Throwable $e) {
                $this->error("Failed to generate recurring invoice for #{$parentInvoice->invoice_number}: {$e->getMessage()}");
            }
        }

        $this->info("Completed. Generated {$count} new recurring invoice(s).");

        return Command::SUCCESS;
    }

    /**
     * Determine if a recurring invoice should run today based on frequency and last execution.
     */
    protected function shouldGenerateToday(Invoice $invoice): bool
    {
        $lastRun = $invoice->last_recurring_at ? Carbon::parse($invoice->last_recurring_at) : null;
        $frequency = strtolower($invoice->recurring_frequency ?? 'monthly');

        if (!$lastRun) {
            return true; // First time run
        }

        return match ($frequency) {
            'daily'     => $lastRun->diffInDays(now()) >= 1,
            'weekly'    => $lastRun->diffInWeeks(now()) >= 1,
            'monthly'   => $lastRun->diffInMonths(now()) >= 1,
            'quarterly' => $lastRun->diffInMonths(now()) >= 3,
            'yearly'    => $lastRun->diffInYears(now()) >= 1,
            default     => $lastRun->diffInMonths(now()) >= 1,
        };
    }
}
