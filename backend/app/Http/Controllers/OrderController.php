<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Services\OrderServiceInterface;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    protected OrderServiceInterface $orderService;

    public function __construct(OrderServiceInterface $orderService)
    {
        $this->orderService = $orderService;
    }

    public function store(StoreOrderRequest $request): JsonResponse
    {
        $order = $this->orderService->createOrder($request->validated());

        return response()->json([
            'message' => 'Order created successfully',
            'data' => $order,
        ], 201);
    }

    public function show($id): JsonResponse
    {
        $order = $this->orderService->getOrderById($id);
    
        return response()->json([
            'message' => 'Order retrieved successfully',
            'data' => $order,
        ]);
    }
}