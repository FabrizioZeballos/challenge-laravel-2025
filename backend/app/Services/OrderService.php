<?php

namespace App\Services;

use App\Repositories\OrderRepositoryInterface;

class OrderService implements OrderServiceInterface
{
    protected OrderRepositoryInterface $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function createOrder(array $data)
    {
        return $this->orderRepository->create($data);
    }

    public function getActiveOrders(): array
    {
        return $this->orderRepository->findActiveOrders();
    }

    public function getOrderById(int $id)
    {
        return $this->orderRepository->findByIdWithItems($id);
    }

    public function advanceOrderState(int $id)
    {
        $order = $this->orderRepository->findByIdWithItems($id);
    
        switch ($order->status) {
            case 'initiated':
                $newStatus = 'sent';
                break;
            case 'sent':
                $newStatus = 'delivered';
                break;
            default:
                throw new \Exception('Unknown order status');
        }
    
        if ($newStatus === 'delivered') {
            $this->orderRepository->delete($id);
            return null; // Or return a message that order was deleted
        } else {
            return $this->orderRepository->updateStatus($id, $newStatus);
        }
    }
}