<?php

namespace App\Listeners;

use App\Events\UserHasRegistered;
use App\Mail\VerifyEmail;
use Illuminate\Support\Facades\Mail;

class SendVerificationEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(UserHasRegistered $event)
    {
      Mail::to($event->user->email)
        ->queue(new VerifyEmail($event->user));
    }
}
