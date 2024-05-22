<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Auth\AuthenticatesUsers;
use Tests\TestCase;

class UserTest extends TestCase
{
    use AuthenticatesUsers;

    /**
     * A basic feature test example.
     */
    public function test_get_all_users_with_invalid_pagination_parameter()
    {
        $token = $this->authenticate('admin@test.ru', 'adminadmin');

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'authorization'=>'Bearer ' . $token,])
            ->getJson('/api/v1/users?page=null');

        $response->assertStatus(404)
            ->assertJson([
                'message' => 'not found',
            ]);
    }

    public function test_get_all_users_with_correct_request(): void
    {
        $token = $this->authenticate('admin@test.ru', 'adminadmin');

        $response = $this->withHeaders([
            'Accept'=>'application/json',
            'authorization'=>'Bearer ' . $token,
        ])->json('GET', '/api/v1/users');

        $response->assertStatus(200);
    }

    public function test_store_user_with_incorrect_empty_title(): void
    {
        $token = $this->authenticate('admin@test.ru', 'adminadmin');

        $response = $this->withHeaders([
            'Accept'=>'application/json',
            'authorization'=>'Bearer ' . $token,
        ])->json('POST', '/api/v1/users', [
            'first_name' => '',
            'last_name' => fake()->name,
            'middle_name' => null,
            'email' => fake()->email,
            'password' => fake()->password(8),
            'phone' => fake()->phoneNumber,
            'default_address' => fake()->address,
            'role' => 2,
        ]);

        $response->assertStatus(422);
    }
    public function test_store_user_with_correct_request(): void
    {
        $token = $this->authenticate('admin@test.ru', 'adminadmin');

        $response = $this->withHeaders([
            'Accept'=>'application/json',
            'authorization'=>'Bearer ' . $token,
        ])->json('POST', '/api/v1/users', [
            'first_name' => fake()->name,
            'last_name' => fake()->lastName,
            'email' => fake()->email,
            'password' => fake()->password(8),
            'phone' => fake()->phoneNumber,
            'default_address' => fake()->address,
            'role' => 2,
        ]);

        $response->assertStatus(200);
    }
    public function test_show_product_user_incorrect_id()
    {
        $token = $this->authenticate('admin@test.ru', 'adminadmin');
        $incorrectId = User::latest()->first()->id + 1;

        $response = $this->withHeaders([
            'Accept'=>'application/json',
            'authorization'=>'Bearer ' . $token,
        ])->json('GET', '/api/v1/users/' . $incorrectId);

        $response->assertStatus(404);
    }

    public function test_show_user_with_last_id()
    {
        $token = $this->authenticate('admin@test.ru', 'adminadmin');
        $id = User::latest()->first()->id;

        $response = $this->withHeaders([
            'Accept'=>'application/json',
            'authorization'=>'Bearer ' . $token,
        ])->json('GET', '/api/v1/users/' . $id);

        $response->assertStatus(200);
    }

    public function test_update_user_with_empty_first_name_request(): void
    {
        $token = $this->authenticate('admin@test.ru', 'adminadmin');
        $id = User::latest()->first()->id;

        $response = $this->withHeaders([
            'Accept'=>'application/json',
            'authorization'=>'Bearer ' . $token,
        ])->json('PUT', '/api/v1/users/' . $id, [
            'first_name' => '',
        ]);

        $response->assertStatus(422);
    }

    public function test_update_user_with_correct_first_name_request(): void
    {
        $token = $this->authenticate('admin@test.ru', 'adminadmin');
        $id = User::latest()->first()->id;
        $name = 'abdsbsb';

        $response = $this->withHeaders([
            'Accept'=>'application/json',
            'authorization'=>'Bearer ' . $token,
        ])->json('PUT', '/api/v1/users/' . $id, [
            'first_name' => $name,
        ]);

        $response->assertStatus(201)->assertJson(['first_name' => $name]);
    }

    public function test_delete_product_with_correct_id(): void
    {
        $token = $this->authenticate('admin@test.ru', 'adminadmin');
        $id = User::latest()->first()->id;

        $response = $this->withHeaders([
            'Accept'=>'application/json',
            'authorization'=>'Bearer ' . $token,
        ])->json('Delete', '/api/v1/users/' . $id );

        $response->assertStatus(200);
    }

    public function test_delete_product_with_incorrect_id(): void
    {
        $token = $this->authenticate('admin@test.ru', 'adminadmin');
        $incorrectId = User::latest()->first()->id + 1;

        $response = $this->withHeaders([
            'Accept'=>'application/json',
            'authorization'=>'Bearer ' . $token,
        ])->json('Delete', '/api/v1/users/' . $incorrectId );

        $response->assertStatus(404);
    }

}
