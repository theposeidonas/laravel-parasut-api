<?php

namespace Theposeidonas\LaravelParasutApi\Tests\Feature\SettingsTest;

use Illuminate\Support\Facades\Http;
use Theposeidonas\LaravelParasutApi\Models\Settings\Category;
use Theposeidonas\LaravelParasutApi\Tests\Feature\BaseTest;

class CategoryTest extends BaseTest
{
    protected Category $category;

    protected function setUp(): void
    {
        parent::setUp();
        $this->category = new Category(config('parasut'));
    }

    public function test_index_categories()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/item_categories' => Http::response([
                'data' => [
                    ['id' => '1', 'type' => 'item_category', 'attributes' => ['name' => 'Category 1']],
                    ['id' => '2', 'type' => 'item_category', 'attributes' => ['name' => 'Category 2']],
                ],
            ], 200),
        ]);

        $response = $this->category->index();

        $this->assertTrue($response['success']);
        $this->assertCount(2, $response['body']->data);
        $this->assertEquals('Category 1', $response['body']->data[0]->attributes->name);
    }

    public function test_create_category()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/item_categories' => Http::response([
                'data' => ['id' => '1', 'type' => 'item_category', 'attributes' => ['name' => 'New Category']],
            ], 201),
        ]);

        $response = $this->category->create(['name' => 'New Category']);

        $this->assertTrue($response['success']);
        $this->assertEquals('New Category', $response['body']->data->attributes->name);
    }

    public function test_show_category()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/item_categories/1' => Http::response([
                'data' => ['id' => '1', 'type' => 'item_category', 'attributes' => ['name' => 'Category 1']],
            ], 200),
        ]);

        $response = $this->category->show('1');

        $this->assertTrue($response['success']);
        $this->assertEquals('Category 1', $response['body']->data->attributes->name);
    }

    public function test_edit_category()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/item_categories/1' => Http::response([
                'data' => ['id' => '1', 'type' => 'item_category', 'attributes' => ['name' => 'Updated Category']],
            ], 200),
        ]);

        $response = $this->category->edit('1', ['name' => 'Updated Category']);

        $this->assertTrue($response['success']);
        $this->assertEquals('Updated Category', $response['body']->data->attributes->name);
    }

    public function test_delete_category()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/item_categories/1' => Http::response([], 204),
        ]);

        $response = $this->category->delete('1');

        $this->assertTrue($response['success']);
        $this->assertEquals(204, $response['status']);
    }
}
