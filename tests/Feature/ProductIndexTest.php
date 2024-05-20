<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use function Laravel\Prompts\password;

class ProductIndexTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_unauthenticated(): void
    {
        $response = $this->withHeaders(['Accept'=>'application/json'])->get('api/v1/product');
        $response->assertStatus(401)->assertJson(['message'=>'Unauthenticated.']);
    }

    public function test_authenticated(): void
    {
        $loginResponse = $this->post(
            'api/v1/login',
            ['email'=>'user@test.ru', 'password'=>'password'],
            ['Accept'=>'application/json']
        )->json();

        $response = $this->withHeaders([
            'Accept'=>'application/json',
            'authorization'=>'Bearer '.$loginResponse['access_token'],
        ])
            ->json('GET', '/api/v1/product');

        $response->assertStatus(200);
    }
}
