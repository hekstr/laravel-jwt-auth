<?php

namespace Tests\Feature\Auth;

use App\Notifications\ForgotPassword;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ForgotPasswordTest extends TestCase
{
  use WithFaker, RefreshDatabase;

  /** @test */
  public function user_can_obtain_reset_password_link()
  {
    Notification::fake();

    $this->withoutExceptionHandling();

    $user = factory(User::class)->create([
      'email' => 'email@example.com'
    ]);

    $this->json('POST', route('password.forgot'), [
      'email' => $user->email
    ]);

    Notification::assertSentTo(
      $user,
      ForgotPassword::class,
      function ($notification) use ($user) {
        $mailData = $notification->toMail($user)->toArray();

        $this->assertEquals('Reset Password Notification', $mailData['subject']);

        return true;
      }
    );
  }

  /** @test */
  public function user_can_reset_password()
  {
    $this->withoutExceptionHandling();

    $user = factory(User::class)->create([
      'email' => 'rano@lptg.pl'
    ]);

    $user->generatePasswordResetToken();

    $this->json('POST', route('password.reset'), [
      'token' => $user->passwordReset->token,
      'password' => 'newPassword',
      'password_confirmation' => 'newPassword',
    ]);

    $user = $user->fresh();

    $this->assertTrue(Hash::check('newPassword', $user->password));
  }

  /** @test */
  public function user_cannot_reset_password_with_incorrect_credentials()
  {
    $credentials = [
      'token' => 'token that does not exist',
      'password' => 'password',
      'password_confirmation' => 'wrong_confirmation'
    ];

    $this->json('POST', route('password.reset'), $credentials)
      ->assertJsonFragment([
        'message' => 'The given data was invalid.'
      ])
      ->assertStatus(422);
  }
}
