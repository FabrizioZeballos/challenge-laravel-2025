<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (Order::count() === 0) {
            Order::factory(5)->create()->each(function ($order) {
                // For each order, create between 1 and 4 order items
                $orderItems = OrderItem::factory(rand(1, 4))->make(); // Make() just creates the models in memory, not in the database.
                $order->items()->saveMany($orderItems);
            });
        } else {
            echo "⚠️ Orders table already seeded. Skipping...\n";
        }
    }
}
