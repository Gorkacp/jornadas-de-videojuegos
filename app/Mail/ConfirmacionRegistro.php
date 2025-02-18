<?php
// filepath: /D:/Xampp/htdocs/jornadas-de-videojuegos/app/Mail/ConfirmacionRegistro.php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmacionRegistro extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this->view('emails.confirmacion')
                    ->subject('Confirma tu registro')
                    ->with(['user' => $this->user]);
    }
}