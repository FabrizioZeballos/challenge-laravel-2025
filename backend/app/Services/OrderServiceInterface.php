<?php

namespace App\Services;

interface OrderServiceInterface
{
    public function getActiveOrders(): array;

    public function getOrderById(int $id);

    public function createOrder(array $data);

    public function advanceOrderState(int $id);
}