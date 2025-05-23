<?php

namespace Tests\Unit;

use App\Models\Order;
use App\Repositories\EloquentOrderRepository;
use App\Services\OrderService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_advance_order_state_from_initiated_to_sent()
    {
        $order = Order::factory()->create(['status' => 'initiated']);
        $service = new OrderService(new EloquentOrderRepository);

        $updatedOrder = $service->advanceOrderState($order->id);

        $this->assertEquals('sent', $updatedOrder->status);
    }

    public function test_advance_order_state_to_delivered_deletes_order()
    {
        $order = Order::factory()->create(['status' => 'sent']);
        $service = new OrderService(new EloquentOrderRepository);

        $result = $service->advanceOrderState($order->id);

        $this->assertNull($result);
        $this->assertDatabaseMissing('orders', ['id' => $order->id]);
    }
}