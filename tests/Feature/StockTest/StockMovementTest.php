<?php

namespace Theposeidonas\LaravelParasutApi\Tests\Feature\StockTest;

use Illuminate\Support\Facades\Http;
use Theposeidonas\LaravelParasutApi\Models\Stock\StockMovement;
use Theposeidonas\LaravelParasutApi\Tests\Feature\BaseTest;

class StockMovementTest extends BaseTest
{
    protected StockMovement $stockMovement;

    protected function setUp(): void
    {
        parent::setUp();
        $this->stockMovement = new StockMovement(config('parasut'));
    }

    public function test_index_stock_movements()
    {
        Http::fake([
            config('parasut.api_url').config('parasut.company_id').'/stock_movements' => Http::response([
                'data' => [
                    ['id' => '1', 'type' => 'stock_movement', 'attributes' => ['date' => '2024-01-01']],
                    ['id' => '2', 'type' => 'stock_movement', 'attributes' => ['date' => '2024-01-02']],
                ],
            ], 200),
        ]);

        $response = $this->stockMovement->index();

        $this->assertTrue($response['success']);
        $this->assertCount(2, $response['body']->data);
        $this->assertEquals('2024-01-01', $response['body']->data[0]->attributes->date);
    }
}
