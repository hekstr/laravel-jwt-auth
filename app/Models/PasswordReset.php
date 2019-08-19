<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
  protected $fillable = [
    'email', 'token'
  ];

  public $timestamps = false;

  public function user()
  {
    return $this->hasOne(User::class, 'email', 'email');
  }
}
