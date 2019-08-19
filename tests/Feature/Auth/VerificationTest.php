<?php

namespace Tests\Feature\Auth;

use App\User;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VerificationTest extends TestCase
{
  use WithFaker, RefreshDatabase;

  /** @test */
  public function user_can_verify_email_address_by_signed_url()
  {
    $this->withoutExceptionHandling();

    $user = factory(User::class)->create([
      'email' => 'email@example.com',
      'email_verified_at' => null
    ]);

    $signedUrl = URL::signedRoute(
      'email.verify', ['id' => $user->id]
    );

    $this->json('GET', $signedUrl)
      ->assertJsonFragment([
        'message' => 'Email verified'
      ]);

    $this->assertDatabaseHas('users', [
      'email' => $user->email,
      'email_verified_at' => now()
    ]);
  }
}
