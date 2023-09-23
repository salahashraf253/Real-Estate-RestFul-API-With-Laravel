<?php

namespace Tests\Unit;

use App\Models\Unit;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Tests\TestCase;

class UnitsTest extends TestCase
{
    use DatabaseTransactions;

    public function test_user_can_get_all_units(): void
    {
        $response = $this->getJson('/api/units');
        $response->assertStatus(HttpResponse::HTTP_OK);
        $response->assertJsonStructure([
            'data'=>[
                '*'=>[
                    'id',
                    'name',
                    'price',
                    'description',
                    'type',
                    'location',
                    'size',
                    'number_of_rooms',
                    'number_of_bathrooms',
                    'city',
                ],
            ],
        ]);
    }

    public function test_user_can_get_unit_by_id()
    {
        $unit = Unit::factory()->create();
        $response = $this->getJson('/api/units/'.$unit->id);
        $response->assertStatus(HttpResponse::HTTP_OK);
        $response->assertJsonStructure([
            'data'=>[
                'id',
                'name',
                'price',
                'description',
                'type',
                'location',
                'size',
                'number_of_rooms',
                'number_of_bathrooms',
                'city',
            ],
        ]);
    }

    public function test_admin_can_create_new_unit()
    {
        $user = User::factory()->create([
            'is_admin'=>1,
        ]);

        $this->actingAs($user);

        $unitData = [
            'name' => 'test',
            'price' => 1000,
            'description' => 'test',
            'type' => 'test',
            'location' => 'test',
            'size' => 100,
            'rooms' => 1,
            'bathrooms' => 1,
            'city' => 'test',
        ];

        $createResponse = $this->postJson('/api/units', $unitData);
        $createResponse->assertStatus(HttpResponse::HTTP_CREATED);
        $createResponse->assertJsonStructure([
            'data' => [
                'id',
            ],
        ]);
    }

    public function test_admin_cannot_create_unit_with_missing_data()
    {
        $user = User::factory()->create([
            'is_admin'=>1,
        ]);

        $this->actingAs($user);

        $unitData = [
            'name' => 'test',
            'price' => 12345,
            'description' => 'test',
            'type' => 'test',
            'location' => 'cairo',
            'size' => 100,
            'rooms' => 4,
            'bathrooms' => 2,
        ];
        $createResponse = $this->postJson('/api/units', $unitData, );
        $createResponse->assertStatus(422);
        $createResponse->assertJson([
            'errors' => [
                'city'=> ['The city field is required.'],
            ],
        ]);
    }

    public function test_unauthorized_user_cannot_create_unit()
    {
        $unitData = [
            'name' => 'test',
            'price' => 1000,
            'description' => 'test',
            'type' => 'test',
            'location' => 'test',
            'size' => 100,
            'rooms' => 1,
            'bathrooms' => 1,
            'city' => 'test',
        ];

        $createResponse = $this->postJson('/api/units', $unitData);
        $createResponse->assertStatus(HttpResponse::HTTP_UNAUTHORIZED);
    }

    public function test_admin_can_update_unit()
    {
        $user = User::factory()->create([
            'is_admin'=>1,
        ]);

        $this->actingAs($user);
        $unit = Unit::factory()->create();
        $newUnitName = 'updated name';
        $unit->name = $newUnitName;

        $updateResponse = $this->patchJson('/api/units/'.$unit->id, $unit->toArray());
        $updateResponse->assertStatus(HttpResponse::HTTP_OK);
        $updateResponse->assertJson([
            'data' => [
                'name'=>$newUnitName,
            ],
        ]);
    }

    public function test_unauthorized_user_cannot_update_unit()
    {
        $unit = Unit::factory()->create();
        $newUnitName = 'updated name';
        $unit->name = $newUnitName;

        $updateResponse = $this->patchJson('/api/units/'.$unit->id, $unit->toArray());
        $updateResponse->assertStatus(HttpResponse::HTTP_UNAUTHORIZED);
    }

    public function test_admin_can_delete_unit()
    {
        $user = User::factory()->create([
            'is_admin'=>1,
        ]);

        $this->actingAs($user);
        $unit = Unit::factory()->create();

        $deleteResponse = $this->deleteJson('/api/units/'.$unit->id);
        $deleteResponse->assertStatus(HttpResponse::HTTP_OK);
        $deleteResponse->assertJson([
            'message' => 'Done',
        ]);
    }

    public function test_unauthorized_user_cannot_delete_unit()
    {
        $unit = Unit::factory()->create();

        $deleteResponse = $this->deleteJson('/api/units/'.$unit->id);
        $deleteResponse->assertStatus(HttpResponse::HTTP_UNAUTHORIZED);
    }
}
