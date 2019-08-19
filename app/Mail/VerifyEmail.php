<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class VerifyEmail extends Mailable
{
  use Queueable, SerializesModels;

  public $user;
  public $url;

  /**
   * Create a new message instance.
   *
   * @param  \App\User  $user
   * @return void
   */
  public function __construct(User $user)
  {
    $this->user = $user;
    $this->url = URL::signedRoute(
      'email.verify', ['id' => $user->id]
    );
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    return $this->markdown('emails.verify-email');
  }
}
