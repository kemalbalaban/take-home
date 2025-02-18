<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use App\Services\Order\OrderService;

class OrderController extends Controller
{
    public function index()
    {
        return (new OrderService())->list();
    }

    public function store(StoreOrderRequest $request)
    {
        return (new OrderService())->store($request);
    }

    public function destroy(Order $order)
    {
        return (new OrderService())->destroy($order);
    }
}
