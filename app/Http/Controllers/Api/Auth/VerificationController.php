<?php

namespace App\Http\Controllers\Api\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VerificationController extends Controller
{
  /**
   * Mark the authenticated user's email address as verified.
   *
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function verify(Request $request)
  {
    $user = User::findOrFail($request->route('id'));

    if ($user->markEmailAsVerified()) {
      return response()->json([
        'message' => 'Email verified'
      ]);
    }
  }
}
