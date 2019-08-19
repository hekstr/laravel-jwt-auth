<?php

namespace App\Events;

use App\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class UserHasRegistered
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  public $user;

  /**
   * Create a new event instance.
   *
   * @param  \app\User $user
   * @return void
   */
  public function __construct(User $user)
  {
    $this->user = $user;
  }
}
