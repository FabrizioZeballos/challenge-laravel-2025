<?php

namespace App\Repositories;

use App\Models\Order;
use Illuminate\Support\Facades\DB;

class EloquentOrderRepository implements OrderRepositoryInterface
{
    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            // 1. Calculate the total
            $total = collect($data['items'])->sum(function ($item) {
                return $item['quantity'] * $item['unit_price'];
            });
        
            // 2. Create the order with total included
            $order = Order::create([
                'client_name' => $data['client_name'],
                'status' => 'initiated',
                'total' => $total,
            ]);
        
            // 3. Create items
            foreach ($data['items'] as $item) {
                $order->items()->create($item);
            }
        
            return $order->load('items');
        });
    }

    public function findActiveOrders(): array
    {
        return Order::where('status', '!=', 'delivered')->get()->toArray();
    }

    public function findByIdWithItems(int $id)
    {
        return Order::with('items')->findOrFail($id);
    }

    public function updateStatus(int $id, string $status)
    {
        $order = Order::findOrFail($id);
        $order->status = $status;
        $order->save();
    
        return $order;
    }
    
    public function delete(int $id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
    }
}