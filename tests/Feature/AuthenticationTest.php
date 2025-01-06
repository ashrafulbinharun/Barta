<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'email' => 'test@user.com',
            'password' => 'password',
        ]);
    }

    public function test_login_page_is_accessible()
    {
        $response = $this->get(route('login'));

        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }

    public function test_register_page_is_accessible()
    {
        $response = $this->get(route('register'));

        $response->assertStatus(200);
        $response->assertViewIs('auth.register');
    }

    public function test_user_can_login()
    {
        $response = $this->post(route('login'), [
            'email' => $this->user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertAuthenticatedAs($this->user);
    }

    public function test_user_can_register()
    {
        $email = fake()->unique()->safeEmail();

        $response = $this->post(route('register'), [
            'name' => fake()->name(),
            'username' => fake()->unique()->userName(),
            'email' => $email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => $email,
        ]);

        $response->assertRedirect(route('home'));
        $this->assertAuthenticated();
    }

    public function test_user_cannot_login_with_invalid_credentials()
    {
        $response = $this->post(route('login'), [
            'email' => $this->user->email,
            'password' => 'wrong_password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_user_cannot_register_with_existing_email()
    {
        $response = $this->post(route('register'), [
            'name' => fake()->name(),
            'username' => fake()->unique()->userName(),
            'email' => $this->user->email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_user_can_logout()
    {
        $this->actingAs($this->user);

        $response = $this->post(route('logout'));

        $response->assertRedirect(route('home'));
        $this->assertGuest();
    }
}
