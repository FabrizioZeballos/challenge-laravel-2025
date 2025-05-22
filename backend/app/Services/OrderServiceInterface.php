<?php

namespace App\Services;

interface OrderServiceInterface
{
    public function createOrder(array $data);

    public function getActiveOrders(): array;


    public function getOrderById(int $id);

    public function advanceOrderState(int $id);
}