<?php

namespace App\Http\Controllers\Api\Auth;

use App\Events\UserHasRegistered;
use App\Http\Requests\Users\Register;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
  public function register(Register $request)
  {
    $user = $this->create($request->all());

    event(new UserHasRegistered($user));
  }

  /**
   * Create a new user instance.
   *
   * @param  array $data
   * @return \App\User
   */
  protected function create(array $data)
  {
    return User::create([
      'name' => $data['name'],
      'email' => $data['email'],
      'password' => Hash::make($data['password']),
    ]);
  }
}
