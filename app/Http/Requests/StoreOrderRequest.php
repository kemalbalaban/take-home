<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class StoreOrderRequest extends FormRequest
{
    public function rules()
    {
        return [
            'customer_id' => 'required|exists:customers,id',
            'items' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'customer_id.required' => 'Müşteri Belirtmediniz.',
            'customer_id.exists' => 'Geçersiz Müşteri',
            'items.required' => 'Siparişe ürün eklemediniz, en az 1 ürün eklemelisiniz.'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'success' => false,
            'message' => 'Validasyon hatası oluştu!',
            'errors' => $validator->errors()
        ], 422);

        throw new HttpResponseException($response);
    }
}

