<?php

namespace Tests\Feature\Auth;

use App\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
  use RefreshDatabase, WithFaker;

  /** @test */
  public function user_can_log_in()
  {
    $this->withoutExceptionHandling();

    factory(User::class)->create([
      'email' => 'email@example.com',
      'password' => Hash::make('secret')
    ]);

    $response = $this->json('POST', '/api/login', [
      'email' => 'email@example.com',
      'password' => 'secret'
    ]);

    $response->assertJsonStructure([
      'access_token',
      'token_type',
      'expires_in'
    ]);
  }

  /** @test */
  public function user_cannot_log_in_without_verified_email()
  {
    $this->withoutExceptionHandling();

    factory(User::class)->create([
      'email' => 'email@example.com',
      'password' => Hash::make('secret'),
      'email_verified_at' => null
    ]);

    $response = $this->json('POST', '/api/login', [
      'email' => 'email@example.com',
      'password' => 'secret'
    ]);

    $response->assertJson(['error' => 'Email Not Verified']);

    $response->assertStatus(401);
  }
}
