<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DebtMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct(User $client)
    {
        $this->user=$client;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Verificacion de deuda')
                    ->markdown('emails.alertNewDebt');
    }
}