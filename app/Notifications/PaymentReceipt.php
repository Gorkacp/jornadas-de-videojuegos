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
                    ->subject('Comprobante de Pago')
                    ->greeting('Hola ' . $this->assistant->name)
                    ->line('Gracias por registrarte en el evento: ' . $this->assistant->event->title)
                    ->line('Tipo de Asistencia: ' . ucfirst($this->assistant->attendance_type))
                    ->line('Adjunto encontrarás tu ticket de entrada.')
                    ->action('Ver Evento', url('/events/' . $this->assistant->event->id))
                    ->line('Gracias por tu participación!');
    }
}