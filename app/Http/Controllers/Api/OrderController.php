<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreOrderRequest;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::latest()->get();
        $formatedOrders = $orders->map(function ($order) {
            return [
                'id' => $order->id,
                'customer_id' => $order->customer_id,
                'items' => $order->orderitem->map(function ($item) {
                    return [
                        'product_id' => $item->product_id,
                        'quantity' => $item->quantity,
                        'unit_price' => $item->unit_price,
                        'total' => $item->total,
                    ];
                }),
                'total' => number_format($order->orderitem->sum(function ($item) {
                    return $item->quantity * $item->product->price;
                }), 2)
            ];
        });
        return response()->json($formatedOrders);
    }

    public function store(StoreOrderRequest $request)
    {
        try {
            return DB::transaction(function () use ($request) {

                $customer = Customer::where('id', '=', $request->customer_id)->firstOrFail();
                if (!$customer) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Müşteri Bulunamadı.'
                    ]);
                }

                if (count($request->items) == 0) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Ürün Eklemediniz, lütfen ürün ekleyiniz.'
                    ]);
                }

                $order = Order::create([
                    'customer_id' => $customer->id,
                    'total' => 0.0
                ]);

                $order->save();
                $orderTotal = 0;
                foreach ($request->items as $item) {
                    $product = Product::where('id', '=', $item['product_id'])->firstOrFail();

                    if ($product->stock < $item['quantity']) {
                        return response()->json([
                            'status' => false,
                            'message' => "{$product->name} Adlı üründe yeteri kadar stok bulunmuyor, kalan stok {$product->stock} adettir."
                        ]);
                    }
                    $product->stock -= $item['quantity'];
                    $product->save();
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $item['quantity'],
                        'unit_price' => $product->price,
                        'total' => $product->price * $item['quantity'],
                    ]);
                    $orderTotal += $item['quantity'] * $product->price;
                }
                $order->total = $orderTotal;
                $order->save();

                return response()->json([
                    'message' => 'Sipariş başarıyla oluşturuldu',
                ], 201);
            });
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Sipariş oluşturulurken bir hata oluştu',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Order $order)
    {
        try {
            return DB::transaction(function () use ($order) {

                foreach ($order->orderitem as $item) {
                    $item->product->update([
                        'stock' => $item->product->stock + $item->quantity
                    ]);
                    $item->delete();
                }

                $order->delete();

                return response()->json([
                    'message' => 'Sipariş başarıyla silindi'
                ]);
            });
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Sipariş silinirken bir hata oluştu'
            ], 500);
        }
    }
}
