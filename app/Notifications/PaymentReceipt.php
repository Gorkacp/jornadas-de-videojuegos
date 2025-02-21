<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentReceipt extends Notification
{
    use Queueable;

    protected $assistant;

    public function __construct($assistant)
    {
        $this->assistant = $assistant;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('Hemos recibido tu pago para el evento: ' . $this->assistant->event->title)
                    ->line('Factura pagada: €' . number_format($this->assistant->event->price, 2))
                    ->action('Ver Evento', url('/events/' . $this->assistant->event->id))
                    ->line('Gracias por tu pago!');
    }
}