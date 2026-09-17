<?php

namespace App\Console\Commands;

use App\Models\Invoice;
use App\Services\WebhookDispatcherService;
use Illuminate\Console\Command;

class MarkOverdueInvoices extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'invoices:mark-overdue';

    /**
     * The console command description.
     */
    protected $description = 'Scan unpaid and partially paid invoices past their due date and mark them as overdue.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Scanning for overdue invoices...');

        $overdueInvoices = Invoice::with(['user', 'customer'])
            ->whereIn('status', ['unpaid', 'partially_paid'])
            ->whereNotNull('due_date')
            ->where('due_date', '<', now()->startOfDay())
            ->get();

        $count = 0;
        $webhookService = app(WebhookDispatcherService::class);

        foreach ($overdueInvoices as $invoice) {
            $invoice->status = 'overdue';
            $invoice->save();
            $count++;

            $this->line("  -> Marked Invoice #{$invoice->invoice_number} as overdue.");

            // Dispatch webhook if configured
            try {
                if ($invoice->user) {
                    $webhookService->dispatchForUser($invoice->user, 'invoice.overdue', [
                        'invoice_id'     => $invoice->id,
                        'invoice_number' => $invoice->invoice_number,
                        'due_date'       => $invoice->due_date?->format('Y-m-d'),
                        'total_amount'   => $invoice->total_amount,
                        'due_amount'     => $invoice->due_amount,
                        'status'         => 'overdue',
                    ]);
                }
            } catch (\Throwable $e) {
                // Ignore webhook failure during batch scan
            }
        }

        $this->info("Completed. Successfully marked {$count} invoice(s) as overdue.");

        return Command::SUCCESS;
    }
}
