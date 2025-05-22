<?php

namespace App\Repositories;

interface OrderRepositoryInterface
{
    public function create(array $data);

    public function findByIdWithItems(int $id);
}