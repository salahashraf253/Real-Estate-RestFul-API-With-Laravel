<?php

namespace Tests\Unit;

use App\Models\Transaction;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Tests\TestCase;

class TransactionsUnitTest extends TestCase
{
    use DatabaseTransactions;

    public function test_admin_can_buy_unit()
    {
        $user = User::factory()->create([
            'is_admin' => 1,
        ]);
        $this->actingAs($user);

        $unit = Unit::factory()->create();

        $response = $this->postJson('/api/units/buy', [
            'unit_id' => $unit->id,
            'user_id' => $user->id,
            'price' => $unit->price,
        ]);

        $response->assertStatus(HttpResponse::HTTP_CREATED);

        $response->assertJson([
            'data' => [
                'user_id' => $user->id,
                'unit_id' => $unit->id,
                'price' => $unit->price,
            ],
        ]);
        $this->assertDatabaseHas('transactions', [
            'user_id' => $user->id,
            'unit_id' => $unit->id,
            'price' => $unit->price,
        ]);
    }

    public function test_authorized_user_can_buy_unit()
    {
        $user = User::factory()->create([
            'is_admin' => 0,
        ]);
        $this->actingAs($user);

        $unit = Unit::factory()->create();

        $response = $this->postJson('/api/units/buy', [
            'unit_id' => $unit->id,
            'user_id' => $user->id,
            'price' => $unit->price,
        ]);

        $response->assertStatus(HttpResponse::HTTP_CREATED);

        $response->assertJson([
            'data' => [
                'user_id' => $user->id,
                'unit_id' => $unit->id,
                'price' => $unit->price,
            ],
        ]);
        $this->assertDatabaseHas('transactions', [
            'user_id' => $user->id,
            'unit_id' => $unit->id,
            'price' => $unit->price,
        ]);
    }

    public function test_unauthorized_user_cannot_buy_unit()
    {
        $unit = Unit::factory()->create();

        $response = $this->postJson('/api/units/buy', [
            'unit_id' => $unit->id,
            'user_id' => 1,
            'price' => $unit->price,
        ]);

        $response->assertStatus(HttpResponse::HTTP_UNAUTHORIZED);
    }

    public function test_authorized_user_cannot_buy_unit_with_invalid_unit_id()
    {
        $user = User::factory()->create([
            'is_admin' => 0,
        ]);
        $unit = Unit::factory()->create();

        $this->actingAs($user);

        $response = $this->postJson('/api/units/buy', [
            'unit_id' => -150,
            'user_id' => $user->id,
            'price' => $unit->price,
        ]);

        $response->assertStatus(HttpResponse::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJson([
            'errors' => [
                'unit_id' => ['The selected unit id is invalid.'],
            ],
        ]);
    }

    public function test_authorized_user_cannot_buy_unit_with_missing_unit_id()
    {
        $user = User::factory()->create([
            'is_admin' => 0,
        ]);
        $unit = Unit::factory()->create();

        $this->actingAs($user);

        $response = $this->postJson('/api/units/buy', [
            'user_id' => $user->id,
            'price' => $unit->price,
        ]);

        $response->assertStatus(HttpResponse::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJson([
            'errors' => [
                'unit_id' => ['The unit id field is required.'],
            ],
        ]);
    }

    public function test_admin_can_list_user_purchases_by_id()
    {
        $admin = User::factory()->create([
            'is_admin' => 1,
        ]);
        $this->actingAs($admin);

        $user = User::factory()->create([
            'is_admin' => 0,
        ]);

        $transaction = Transaction::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->getJson('/api/transactions/'.$user->id);
        $response->assertStatus(HttpResponse::HTTP_OK);
        $response->assertJson([
            'data' => [
                [
                    'id' => $transaction->id,
                    'user_id' => $transaction->user_id,
                    'unit_id' => $transaction->unit_id,
                    'price' => $transaction->price,
                ],
            ],
        ]);
    }

    public function test_admin_can_list_all_users_purchases()
    {
        $admin = User::factory()->create([
            'is_admin' => 1,
        ]);
        $this->actingAs($admin);

        $response = $this->getJson('/api/transactions/');
        $response->assertStatus(HttpResponse::HTTP_OK);
    }

    public function test_authenticated_user_can_show_his_transactions()
    {
        $user = User::factory()->create([
            'is_admin' => 0,
        ]);
        $this->actingAs($user);

        $transaction = Transaction::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->getJson('/api/users/purchases/'.$user->id);

        $response->assertStatus(HttpResponse::HTTP_OK);
        $response->assertJson([
            'data' => [
                [
                    'id' => $transaction->id,
                    'user_id' => $transaction->user_id,
                    'unit_id' => $transaction->unit_id,
                    'price' => $transaction->price,
                ],
            ],
        ]);
    }

    public function test_authenticated_user_cannot_show_other_users_transactions()
    {
        $user = User::factory()->create([
            'is_admin' => 0,
        ]);
        $this->actingAs($user);

        $transaction = Transaction::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->getJson('/api/users/purchases/1');

        $response->assertStatus(HttpResponse::HTTP_FORBIDDEN);
    }
}
