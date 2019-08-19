<?php

namespace Tests\Feature\Auth;

use App\Mail\VerifyEmail;
use App\User;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationTest extends TestCase
{
  use WithFaker, RefreshDatabase;

  /** @test */
  public function guest_can_register()
  {
    Mail::fake();

    $this->withoutExceptionHandling();

    $credentials = [
      'name' => 'Some Name',
      'email' => 'email@example.com',
      'password' => 'secret'
    ];

    $this->json('POST', '/api/register', $credentials);

    $this->assertDatabaseHas('users', ['email' => 'email@example.com']);

    Mail::assertQueued(VerifyEmail::class, function ($mail) {
      return $mail->hasTo('email@example.com');
    });
  }

  /** @test */
  public function user_cannot_register_with_email_taken()
  {
    factory(User::class)->create([
      'email' => 'email@example.com',
    ]);

    $credentials = [
      'name' => 'Some Name',
      'email' => 'email@example.com',
      'password' => 'secret'
    ];

    $this->json('POST', '/api/register', $credentials)
      ->assertJsonFragment([
        'email' => ['The email has already been taken.']
      ])
      ->assertStatus(422);
  }

  /** @test */
  public function user_cannot_register_with_incorrect_credentials()
  {
    $credentials = [
      'name' => null,
      'email' => null,
      'password' => null
    ];

    $this->json('POST', '/api/register', $credentials)
      ->assertJsonFragment([
        'name' => ['The name field is required.'],
        'email' => ['The email field is required.'],
        'password' => ['The password field is required.']
      ])
      ->assertStatus(422);
  }
}
