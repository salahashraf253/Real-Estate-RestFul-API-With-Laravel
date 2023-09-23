<?php

namespace Tests\Unit;

use App\Models\Unit;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Tests\TestCase;

class UnitsFilterTest extends TestCase
{
    use DatabaseTransactions;

    public function test_user_can_filter_by_name()
    {
        $unit = Unit::factory()->create([
            'name'=>'Unit 1',
        ]);
        $response = $this->getJson('/api/units?name=Unit 1');
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

    public function test_user_can_filter_by_price()
    {
        $unit = Unit::factory()->create([
            'price'=>1000,
        ]);
        $response = $this->getJson('/api/units?price=1000');
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

    public function test_user_can_filter_by_location()
    {
        $unit = Unit::factory()->create([
            'location'=>'Unit 1, Egypt',
        ]);
        $response = $this->getJson('/api/units?location=Unit 1');
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

    public function test_user_can_filter_by_room()
    {
        $unit = Unit::factory()->create([
            'rooms'=>1,
        ]);
        $response = $this->getJson('/api/units?rooms=1');
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

    public function test_user_can_filter_by_city()
    {
        $unit = Unit::factory()->create([
            'city'=>'Cairo',
        ]);
        $response = $this->getJson('/api/units?city=Cairo');
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

    public function test_user_can_filter_by_description()
    {
        $unit = Unit::factory()->create([
            'description' => 'nice unit',
        ]);
        $response = $this->getJson('/api/units?description=nice unit');
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

    public function test_user_can_filter_by_type()
    {
        $unit = Unit::factory()->create([
            'type' => 'villa',
        ]);
        $response = $this->getJson('/api/units?type=apartment');
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

    public function test_user_can_filter_by_bathrooms()
    {
        $unit = Unit::factory()->create([
            'bathrooms' => 1,
        ]);
        $response = $this->getJson('/api/units?bathrooms=1');
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

    public function test_user_can_filter_by_size()
    {
        $unit = Unit::factory()->create([
            'size' => 160,
        ]);
        $response = $this->getJson('/api/units?size=100');
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
}
