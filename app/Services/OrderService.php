<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Pizza;
use Illuminate\Support\Facades\DB;

class OrderService
{
    /**
     * @param array $data
     * @return Order
     */
    public function createOrder(array $data): Order
    {
        return DB::transaction(function () use ($data) {
            $order = $this->createOrderRecord($data);
            $this->createOrderItems($order, $data['items']);

            return $order;
        });
    }

    /**
     * @param array $data
     * @return Order
     */
    private function createOrderRecord(array $data): Order
    {
        return Order::create([
            'user_id' => auth()->id() ?? null,
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'] ?? null,
            'phone' => $data['phone'],
            'email' => $data['email'],
            'address' => $data['address'],
            'comment' => $data['comment'] ?? null,
            'total_price' => $data['total_price'],
        ]);
    }

    /**
     * @param Order $order
     * @param array $items
     * @return void
     */
    private function createOrderItems(Order $order, array $items): void
    {
        $pizza_ids = collect($items)
            ->pluck('pizza_id')
            ->unique();
        $pizzas = Pizza::whereIn('id', $pizza_ids)
            ->get()
            ->keyBy('id');

        $order_items = collect($items)->map(function ($item) use ($pizzas) {
            $pizza = $pizzas[$item['pizza_id']];

            return [
                'pizza_id' => $pizza->id,
                'pizza_name' => $pizza->name,
                'size' => $item['size'],
                'crust' => $item['crust'],
                'addons' => json_encode($item['addons'] ?? []),
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'full_price' => $item['full_price'],
            ];
        });

        $order->items()->createMany($order_items->toArray());
    }
}
