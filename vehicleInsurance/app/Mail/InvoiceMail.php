<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;



 
use Illuminate\Contracts\Queue\ShouldQueue;
 
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
 

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;
 

    public $data;
    public $pdfContent;
    public $isRawPdf;

    public function __construct($pdf, $data, $isRawPdf = false)
    {
        $this->data = $data;
        $this->pdfContent = $pdf;
        $this->isRawPdf = $isRawPdf;
    }

    public function build()
    {
        $email = $this->view('emails.invoice')
            ->subject('فاتورة المشاركة - ' . $this->data['invoice_id']);
            
        if ($this->isRawPdf) {
            return $email->attachData($this->pdfContent, 'Invoice_'.$this->data['invoice_id'].'.pdf', [
                'mime' => 'application/pdf',
            ]);
        } else {
            return $email->attachData($this->pdfContent->output(), 'Invoice_'.$this->data['invoice_id'].'.pdf', [
                'mime' => 'application/pdf',
            ]);
        }
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Verify Participant Email',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.invoice_notification',
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

 