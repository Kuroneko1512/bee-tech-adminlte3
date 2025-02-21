<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MonthlyPurchaseReport extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $reportData;
    /**
     * Create a new message instance.
     */
    public function __construct($reportData)
    {
        $this->reportData = $reportData;
        // Chỉ định queue name trong constructor
        $this->onQueue('monthly-reports');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            // subject: 'Monthly Purchase Report',
            subject: 'Báo cáo mua hàng tháng ' . now()->subMonth()->format('m/Y'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'view.monthly-report',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
