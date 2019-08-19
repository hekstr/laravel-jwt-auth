<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ForgotPassword extends Notification
{
  use Queueable;

  protected $token;

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
   * @param  mixed $notifiable
   * @return array
   */
  public function via($notifiable)
  {
    return ['mail'];
  }

  /**
   * Get the mail representation of the notification.
   *
   * @param  mixed $notifiable
   * @return \Illuminate\Notifications\Messages\MailMessage
   */
  public function toMail($notifiable)
  {
    $url = config('services.client') . '/password/reset/' . $this->token;

    return (new MailMessage)
      ->subject('Reset Password Notification')
      ->greeting('Greetings!')
      ->line('You are receiving this email because we received a password reset request for your account.')
      ->action('Reset password', $url)
      ->line('If you did not request a password reset, no further action is required.');

  }
}
