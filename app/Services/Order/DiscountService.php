<?php

namespace App\Services\Order;

use App\Models\Order;
use App\Models\DiscountRule;

class DiscountService
{
    public function applyDiscounts(Order $order)
    {
        $totalPrice = $order->orderitem->sum(fn($p) => $p->product->price * $p->quantity);

        $discount = 0;
        $discountDetails = [];
        $discountRules = $this->getDiscountRules();

        foreach ($discountRules as $rule) {

            if ($rule->min_order_total && $totalPrice >= $rule->min_order_total) {
                $discountAmount = $totalPrice * ($rule->value / 100);
                $discount += $discountAmount;

                $discountDetails[] = [
                    "discountReason" => $rule->name,
                    "discountAmount" => number_format($discountAmount, 2, '.', ''),
                    "subtotal" => number_format($totalPrice - $discountAmount, 2, '.', ''),
                ];
            }

            foreach ($order->orderitem as $product) {
                if ($rule->category_id && $product->category_id == $rule->category_id) {
                    if ($rule->min_quantity && $product->quantity >= $rule->min_quantity) {
                        if ($rule->type == 'free_item') {
                            // 6 tane alınca 1 bedava
                            $freeItems = intdiv($product->quantity, $rule->min_quantity);
                            $discountAmount = $freeItems * $product->price;
                            $discount += $discountAmount;

                            $discountDetails[] = [
                                "discountReason" => $rule->name,
                                "discountAmount" => number_format($discountAmount, 2, '.', ''),
                                "subtotal" => number_format($totalPrice - $discount, 2, '.', ''),
                            ];
                        } elseif ($rule->type == 'percentage') {

                            $cheapestProduct = $order->products->where('category_id', $rule->category_id)->sortBy('price')->first();
                            if ($cheapestProduct) {
                                $discountAmount = $cheapestProduct->price * ($rule->value / 100);
                                $discount += $discountAmount;

                                $discountDetails[] = [
                                    "discountReason" => $rule->name,
                                    "discountAmount" => number_format($discountAmount, 2, '.', ''),
                                    "subtotal" => number_format($totalPrice - $discount, 2, '.', ''),
                                ];
                            }
                        }
                    }
                }
            }
        }

        $order->discount_applied = $discount;
        $order->final_price = $totalPrice - $discount;
        $order->save();

        return response()->json([
            "orderId" => $order->id,
            "discounts" => $discountDetails,
            "totalDiscount" => number_format($discount, 2, '.', ''),
            "discountedTotal" => number_format($totalPrice - $discount, 2, '.', '')
        ]);
    }

    public function getDiscountRules()
    {
        return DiscountRule::all();
    }
}
