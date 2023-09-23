<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use DatabaseTransactions;

    public function test_user_can_login()
    {
        $user = User::factory()->create(
            ['email' =>fake()->unique()->safeEmail(),
            'password'=>'password1234',
            'name'=>'test name']
        );

        $loginData = [
            'email' => $user->email,
            'password' => 'password1234',
        ];

        $response = $this->post('/api/login', $loginData);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data'=>[
                'access_token',
            ],
            'message',
        ]);
    }

    public function test_user_can_register()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'test name',
            'email' => fake()->unique()->safeEmail(),
            'password' => 'password1234',
        ]);
        $response->assertStatus(201);
        // dd($response->json());
        $response->assertJsonStructure([
            'data'=>[
                'id',
                'name',
                'email',
            ],
            'message',
        ]);
    }

    public function test_user_can_not_register_with_invalid_email()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'test name',
            'email' => 'testgmail.com',
            'password' => 'password1234',
        ]);
        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'The email field must be a valid email address.',
        ]);
    }

    public function test_user_can_not_register_with_invalid_password()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'test name',
            'email' => fake()->unique()->safeEmail(),
            'password' => '1234',
        ]);
        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'The password field must be at least 8 characters.',
        ]);
    }

    public function test_user_can_not_register_with_invalid_name()
    {
        $response = $this->postJson('/api/register', [
            'name' => '',
            'email' => fake()->unique()->safeEmail(),
            'password' => 'password1234',
        ]);
        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'The name field is required.',
        ]);
    }

    public function test_user_can_not_register_with_same_email()
    {
        $user = User::factory()->create(
            ['email' =>fake()->unique()->safeEmail(),
            'password'=>'password1234',
            'name'=>'test name']
        );
        $response = $this->postJson('/api/register', [
            'name' => 'test name',
            'email' => $user->email,
            'password' => 'password1234',
        ]);
        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'The email has already been taken.',
        ]);
    }
}
