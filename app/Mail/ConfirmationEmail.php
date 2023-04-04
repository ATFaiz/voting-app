<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Voter;

class ConfirmationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $voter;

    /**
     * Create a new message instance.
     *
     * @param  Voter  $voter
     * @return void
     */
    public function __construct(Voter $voter)
    {
        $this->voter = $voter;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Voter Registration Confirmation')
                    ->view('emails.voter-confirmation');
    }
}
