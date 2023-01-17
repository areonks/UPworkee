<?php

namespace App\Mail;

use App\Http\Resources\JobVacancyResource;
use App\Models\VacancyResponse;
use App\Repositories\JobVacancyRepositoryInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VacancyResponseReceived extends Mailable
{
    use Queueable, SerializesModels;

//    public $connection = 'redis';
//    public $delay = 3600;
//    public $queue = 'urgent';

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $vacancyResponse;

    public function __construct(VacancyResponse $vacancyResponse)
    {
        $this->vacancyResponse = $vacancyResponse;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Vacancy Response Received',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            markdown: 'emails.response.received',
            with: [
                'url' => '$this->id',
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
