<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RecoveryPassword extends Notification
{
    use Queueable;
    
    public $token;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                ->subject('Recuperación de contraseña - MetaCRM')
                ->greeting('Recuperación de contraseña')
                ->line('Hemos recibido una solicitud para restablecer la contraseña')
                ->line('Su código de recuperación es:')
                ->line(new \Illuminate\Support\HtmlString('<p style="font-size:20px;text-align:center;letter-spacing: 2px;"><b>'.$this->token.'</b></p>'))
                ->action('Ingrese a MetaCRM',config('app.url'))
                ->salutation(' ')
                ->line('Gracias por usar MetaCRM');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
