<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StakeholderInvitation extends Mailable
{
    use Queueable, SerializesModels;

    public $invitationLink;

    public function __construct($invitationLink)
    {
        $this->invitationLink = $invitationLink;
    }

    public function build()
    {
        return $this->subject('Stakeholder Invitation')
            ->view('emails.undangan_stakeholder');
    }
}