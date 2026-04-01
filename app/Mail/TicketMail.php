<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TicketMail extends Mailable
{
    use Queueable, SerializesModels;

    public Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Ваши билеты в театр',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.tickets',
            with: [
                'order' => $this->order,
                'customerName' => $this->order->customer_name,
            ]
        );
    }

    public function attachments(): array
    {
        $attachments = [];
        
        foreach ($this->order->tickets as $ticket) {
            $pdfPath = storage_path('app/tickets/ticket_' . $ticket->id . '.pdf');
            if (file_exists($pdfPath)) {
                $attachments[] = Attachment::fromPath($pdfPath)
                    ->as('ticket_' . $ticket->id . '.pdf')
                    ->withMime('application/pdf');
            }
        }
        
        return $attachments;
    }
}