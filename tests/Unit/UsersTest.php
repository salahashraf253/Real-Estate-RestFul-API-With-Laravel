<?php

namespace Tests\Unit;

use App\Models\User;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Tests\TestCase;

class UsersTest extends TestCase
{
    public function test_admin_can_list_all_users(): void
    {
        $user = User::factory()->create([
            'is_admin'=>1,
        ]);

        $this->actingAs($user);

        $response = $this->getJson('/api/users');
        $response->assertStatus(HttpResponse::HTTP_OK);
        $response->assertJsonStructure([
            'data'=>[
                '*'=>[
                    'id',
                    'name',
                    'email',
                ],
            ],
        ]);
    }

    public function test_admin_can_delete_user()
    {
        $user = User::factory()->create([
            'is_admin'=>1,
        ]);

        $this->actingAs($user);

        $userToDelete = User::factory()->create();
        $response = $this->deleteJson('/api/users/'.$userToDelete->id);
        $response->assertStatus(HttpResponse::HTTP_OK);
        $response->assertJsonStructure([
            'message',
        ]);
    }

    public function test_unauthorized_user_cannot_delete_user()
    {
        $userToDelete = User::factory()->create();
        $response = $this->deleteJson('/api/users/'.$userToDelete->id);
        $response->assertStatus(HttpResponse::HTTP_UNAUTHORIZED);
    }

    public function test_unauthorized_user_cannot_list_all_users()
    {
        $userToDelete = User::factory()->create([
            'is_admin'=>0,
        ]);
        $response = $this->deleteJson('/api/users/'.$userToDelete->id);
        $response->assertStatus(HttpResponse::HTTP_UNAUTHORIZED);
    }
}
