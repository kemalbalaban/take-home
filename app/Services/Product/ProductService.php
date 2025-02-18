<?php

namespace App\Services\Product;

use App\Models\Product;

class ProductService{

    public function updateProductStock(Product $product, int $value = 1, $operation = 'up'): Product
    {
        if ($operation == 'up') {
            $data = [
                'stock' => $product->stock + $value
            ];
        } else {
            $data = [
                'stock' => $product->stock - $value
            ];
        }
        $product->update($data);

        return $product;
    }

    public function stockCheckAndDecrease($product_id, $quantity)
    {
        $product = Product::where('id','=',$product_id)->firstOrFail();
        if ($product->stock < $quantity) {
            return response()->json([
                'status' => false,
                'message' => "{$product->name} Adlı üründe yeteri kadar stok bulunmuyor, kalan stok {$product->stock} adettir."
            ]);
        }
        return $this->updateProductStock($product, $quantity, 'down');
    }
}
