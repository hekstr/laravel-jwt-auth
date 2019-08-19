<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\PasswordReset;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\ForgotPassword;
use App\Http\Requests\Password\Reset as ResetPasswordRequest;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
  public function getPasswordResetToken(Request $request)
  {
    $user = User::where('email', $request->email)->first();

    $user->generatePasswordResetToken();

    $user->notify(
      new ForgotPassword($user->passwordReset->token)
    );

    return response()->json([
      'message' => 'We have e-mailed your password reset link!'
    ]);
  }

  public function resetPassword(ResetPasswordRequest $request)
  {
    $passwordReset = PasswordReset::whereToken($request->token)->first();

    $passwordReset->user->update([
      'password' => Hash::make($request->password)
    ]);

    return response()->json([
      'message' => 'Password reset successfully.'
    ]);
  }
}
