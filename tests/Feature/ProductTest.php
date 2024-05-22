<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use function Laravel\Prompts\password;

class ProductTest extends TestCase
{
    use AuthenticatesUsers;

    /**
     * A basic feature test example.
     */
    public function test_get_all_products_with_invalid_pagination_parameter()
    {
        $response = $this->withHeaders(['Accept' => 'application/json'])
            ->getJson('/api/v1/products?page=null');

        $response->assertStatus(404)
            ->assertJson([
                'message' => 'not found',
            ]);
    }

    public function test_get_all_products_with_correct_request(): void
    {
        $token = $this->authenticate('admin@test.ru', 'adminadmin');

        $response = $this->withHeaders([
            'Accept'=>'application/json',
            'authorization'=>'Bearer ' . $token,
        ])->json('GET', '/api/v1/products');

        $response->assertStatus(200);
    }

    public function test_store_product_with_incorrect_empty_title(): void
    {
        $token = $this->authenticate('admin@test.ru', 'adminadmin');

        $response = $this->withHeaders([
            'Accept'=>'application/json',
            'authorization'=>'Bearer ' . $token,
        ])->json('POST', '/api/v1/product', [
            'title' => '',
            'description' => 'test test',
            'price' => 500.00,
            'product_type_id' => 1,
            'is_active' => true,
            ]);

        $response->assertStatus(422);
    }
    public function test_store_product_with_correct_request(): void
    {
        $token = $this->authenticate('admin@test.ru', 'adminadmin');

        $response = $this->withHeaders([
            'Accept'=>'application/json',
            'authorization'=>'Bearer ' . $token,
        ])->json('POST', '/api/v1/product', [
            'title' => 'title',
            'description' => 'test test',
            'price' => '500.00',
            'product_type_id' => 1,
            'is_active' => true,
        ]);

        $response->assertStatus(201);
    }
    public function test_show_product_with_incorrect_id()
    {
        $token = $this->authenticate('admin@test.ru', 'adminadmin');
        $incorrectId = Product::latest()->first()->id + 1;

        $response = $this->withHeaders([
            'Accept'=>'application/json',
            'authorization'=>'Bearer ' . $token,
        ])->json('GET', '/api/v1/product/' . $incorrectId);

        $response->assertStatus(404);
    }

    public function test_show_product_with_last_id()
    {
        $token = $this->authenticate('admin@test.ru', 'adminadmin');
        $id = Product::latest()->first()->id;

        $response = $this->withHeaders([
            'Accept'=>'application/json',
            'authorization'=>'Bearer ' . $token,
        ])->json('GET', '/api/v1/product/' . $id);

        $response->assertStatus(200);
    }

    public function test_update_product_with_empty_title_request(): void
    {
        $token = $this->authenticate('admin@test.ru', 'adminadmin');
        $id = Product::latest()->first()->id;

        $response = $this->withHeaders([
            'Accept'=>'application/json',
            'authorization'=>'Bearer ' . $token,
        ])->json('PUT', '/api/v1/product/' . $id, [
            'title' => '',
        ]);

        $response->assertStatus(422);
    }

    public function test_update_product_with_correct_title_request(): void
    {
        $token = $this->authenticate('admin@test.ru', 'adminadmin');
        $id = Product::latest()->first()->id;
        $title = 'trtrtrtrt';

        $response = $this->withHeaders([
            'Accept'=>'application/json',
            'authorization'=>'Bearer ' . $token,
        ])->json('PUT', '/api/v1/product/' . $id, [
            'title' => $title,
        ]);

        $response->assertStatus(201)->assertJson(['title' => $title]);
    }

    public function test_delete_product_with_correct_id(): void
    {
        $token = $this->authenticate('admin@test.ru', 'adminadmin');
        $id = Product::latest()->first()->id;
        echo $id;
        $response = $this->withHeaders([
            'Accept'=>'application/json',
            'authorization'=>'Bearer ' . $token,
        ])->json('Delete', '/api/v1/product/' . $id );

        $response->assertStatus(200);
    }

    public function test_delete_product_with_incorrect_id(): void
    {
        $token = $this->authenticate('admin@test.ru', 'adminadmin');
        $incorrectId = Product::latest()->first()->id + 1;

        $response = $this->withHeaders([
            'Accept'=>'application/json',
            'authorization'=>'Bearer ' . $token,
        ])->json('Delete', '/api/v1/product/' . $incorrectId );

        $response->assertStatus(404);
    }

    public function test_add_product_image_with_incorrect_file_extension(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->create('test_file.txt', 100, 'text/plain');
        $id = Product::latest()->first()->id;
        $token = $this->authenticate('admin@test.ru', 'adminadmin');

        $response = $this->withHeaders([
            'Accept'=>'application/json',
            'authorization'=>'Bearer ' . $token,
        ])->json('POST', "/api/v1/product/$id/images", [
            "img_src" => [$file],
        ]);

        $response->assertStatus(422);
    }
    public function test_add_product_image_with_correct_file_extension(): void
    {
        Storage::fake('public');

        $image = UploadedFile::fake()->image('test_image.jpg');
        $id = Product::latest()->first()->id;
        $token = $this->authenticate('admin@test.ru', 'adminadmin');

        $response = $this->withHeaders([
            'Accept'=>'application/json',
            'authorization'=>'Bearer ' . $token,
        ])->json('POST', "/api/v1/product/$id/images", [
            "img_src" => [$image],
        ]);

        $response->assertStatus(201);
    }
}
