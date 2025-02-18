<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\Order\DiscountService;
use App\Services\Order\OrderService;

class DiscountController extends Controller
{
    protected $discountService;
    protected $orderService;

    public function __construct(DiscountService $discountService, OrderService  $orderService)
    {
        $this->discountService = $discountService;
        $this->orderService = $orderService;
    }

    public function applyDiscount($orderId)
    {

        $order = $this->orderService->getOrder($orderId);
        $updatedOrder = $this->discountService->applyDiscounts($order);

        return response()->json($updatedOrder);
    }

    public function getDiscountRules()
    {
        return response()->json($this->discountService->getDiscountRules());
    }
}
