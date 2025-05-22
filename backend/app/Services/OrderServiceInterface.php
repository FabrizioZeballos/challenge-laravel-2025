<?php

namespace App\Services;

interface OrderServiceInterface
{
    public function createOrder(array $data);

    public function getOrderById(int $id);
}