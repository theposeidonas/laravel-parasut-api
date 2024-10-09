<?php

namespace Theposeidonas\LaravelParasutApi\Tests\Feature\SettingsTest;

use Illuminate\Support\Facades\Http;
use Theposeidonas\LaravelParasutApi\Models\Settings\Tag;
use Theposeidonas\LaravelParasutApi\Tests\Feature\BaseTest;

class TagTest extends BaseTest
{
    protected Tag $tag;

    protected function setUp(): void
    {
        parent::setUp();
        $this->tag = new Tag(config('parasut'));
    }

    public function test_index_tags()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/tags' => Http::response([
                'data' => [
                    ['id' => '1', 'type' => 'tag', 'attributes' => ['name' => 'Tag 1']],
                    ['id' => '2', 'type' => 'tag', 'attributes' => ['name' => 'Tag 2']],
                ],
            ], 200),
        ]);

        $response = $this->tag->index();

        $this->assertTrue($response['success']);
        $this->assertCount(2, $response['body']->data);
        $this->assertEquals('Tag 1', $response['body']->data[0]->attributes->name);
    }

    public function test_create_tag()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/tags' => Http::response([
                'data' => ['id' => '1', 'type' => 'tag', 'attributes' => ['name' => 'New Tag']],
            ], 201),
        ]);

        $response = $this->tag->create(['name' => 'New Tag']);

        $this->assertTrue($response['success']);
        $this->assertEquals('New Tag', $response['body']->data->attributes->name);
    }

    public function test_show_tag()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/tags/1' => Http::response([
                'data' => ['id' => '1', 'type' => 'tag', 'attributes' => ['name' => 'Tag 1']],
            ], 200),
        ]);

        $response = $this->tag->show('1');

        $this->assertTrue($response['success']);
        $this->assertEquals('Tag 1', $response['body']->data->attributes->name);
    }

    public function test_edit_tag()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/tags/1' => Http::response([
                'data' => ['id' => '1', 'type' => 'tag', 'attributes' => ['name' => 'Updated Tag']],
            ], 200),
        ]);

        $response = $this->tag->edit('1', ['name' => 'Updated Tag']);

        $this->assertTrue($response['success']);
        $this->assertEquals('Updated Tag', $response['body']->data->attributes->name);
    }

    public function test_delete_tag()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/tags/1' => Http::response([], 204),
        ]);

        $response = $this->tag->delete('1');

        $this->assertTrue($response['success']);
        $this->assertEquals(204, $response['status']);
    }
}
