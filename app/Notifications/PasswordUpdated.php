<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordUpdated extends Notification
{
    use Queueable;

    public function __construct()
    {
        //
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Sua senha foi atualizada')
            ->greeting("Olá {$notifiable->name}!")
            ->line('Este email confirma que a senha de sua conta foi alterada.')
            ->line('Se você não teve intenção de alterar sua senha, entre em contato com o Suporte.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
