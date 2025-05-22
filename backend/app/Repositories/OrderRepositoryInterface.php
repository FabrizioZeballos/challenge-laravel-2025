<?php

namespace App\Repositories;

interface OrderRepositoryInterface
{
    public function create(array $data);

    public function findActiveOrders(): array;

    public function findByIdWithItems(int $id);

    public function updateStatus(int $id, string $status);

    public function delete(int $id);
}