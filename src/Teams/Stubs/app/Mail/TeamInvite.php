<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TeamInvite extends Mailable
{
    use Queueable, SerializesModels;

    public $invite;

    /**
     * Create a new message instance.
     */
    public function __construct($invite)
    {
        $this->invite = $invite;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $teamName = ucfirst($this->invite->team->name);
        $appName = config('app.name');

        return $this->markdown('emails.team.invite')
                    ->subject("$appName: $teamName has invited you.")
                    ->to($this->invite->email);
    }
}
