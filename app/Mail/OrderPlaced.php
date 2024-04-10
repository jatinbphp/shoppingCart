<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderPlaced extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data){
        $this->data = $data;
    }

    
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Order Received: #' . 'INV-'. date('Y', strtotime($this->data['order']->created_at)) . '-' . $this->data['order']->id,
        );
    }

    
    public function content(): Content{
        return new Content(
            view: 'mail-templates.orders.order-placed',
            with: [
                'order' => $this->data['order'],
                'user'  => $this->data['user'],
            ],
        );
    }

   
    public function attachments(): array
    {
        return [];
    }
}
