<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['nullable', 'string', 'max:100'],
            'phone' => ['required', 'string', 'max:20'],
            'email' => ['required', 'email', 'max:255'],
            'address' => ['required', 'string', 'max:250'],
            'comment' => ['nullable', 'string', 'min:10', 'max:300'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.pizza_id' => ['required', 'exists:pizzas,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1', 'max:10'],
            'items.*.size' => ['required', 'string'],
            'items.*.crust' => ['required', 'string'],
            'items.*.addons' => ['array'],
            'items.*.addons.*' => ['string'],
            'items.*.unit_price' => ['required', 'numeric', 'min:0'],
            'items.*.full_price' => ['required', 'numeric', 'min:0'],
            'total_price' => ['required', 'numeric', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'Имя обязательно для заполнения',
            'email' => [
                'required' => 'Email обязателен для заполнения',
                'email' => 'Введен некорректный Email',
            ],
            'phone.required' => 'Телефон обязателен для заполнения',
            'address.required' => 'Адрес обязателен для заполнения',
        ];
    }
}
