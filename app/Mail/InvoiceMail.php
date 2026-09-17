<?php

namespace App\Mail;

use App\Models\Invoice;
use App\Services\InvoiceService;
use App\Services\SettingService;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $companyData;
    public string $senderName;
    public string $senderEmail;
    public bool $attachPdf;

    /**
     * @param Invoice $invoice   The invoice to send
     * @param bool    $attachPdf Whether to attach a PDF
     */
    public function __construct(
        public readonly Invoice $invoice,
        bool $attachPdf = true,
    ) {
        $this->invoice->loadMissing(['customer', 'user.settings']);

        $this->companyData  = SettingService::getCompanyData($invoice->user);
        $this->senderName   = $this->companyData['company_name'] ?? ($invoice->user->name ?? 'Invozen');
        $this->senderEmail  = $this->companyData['company_email'] ?? ($invoice->user->email ?? config('mail.from.address'));
        $this->attachPdf    = $attachPdf;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Invoice #{$this->invoice->invoice_number} from {$this->senderName}",
            replyTo: $this->senderEmail,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.invoice-sent',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        if (!$this->attachPdf) {
            return [];
        }

        try {
            $pdfContent = InvoiceService::generatePdf($this->invoice)->output();

            return [
                Attachment::fromData(
                    fn () => $pdfContent,
                    "invoice-{$this->invoice->invoice_number}.pdf"
                )->withMime('application/pdf'),
            ];
        } catch (\Throwable) {
            return [];
        }
    }
}
