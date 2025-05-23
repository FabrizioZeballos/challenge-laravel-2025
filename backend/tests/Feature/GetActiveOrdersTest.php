<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Order;
use App\Models\OrderItem;

class GetActiveOrdersTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_active_orders_returns_only_non_delivered()
    {
        Order::factory()->create(['status' => 'initiated']);
        Order::factory()->create(['status' => 'sent']);
        Order::factory()->create(['status' => 'delivered']);

        $response = $this->getJson('/api/orders');

        $response->assertStatus(200);
        $this->assertCount(2, $response->json());
    }
}