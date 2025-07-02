<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Services\OrderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class OrderController extends Controller
{
    public function __construct(private OrderService $order_service) {}

    /**
     * Рендер  страницы заказа
     *
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        return Inertia::render('Order/Create', [
            'user' => $request->user() ?? null,
        ]);
    }

    /**
     * Оформление заказа
     *
     * @param StoreOrderRequest $request
     * @return RedirectResponse
     */
    public function store(StoreOrderRequest $request): RedirectResponse
    {
        try {
            $order = $this->order_service->createOrder($request->validated());

            return redirect()
                ->route('order.show', ['uuid' => $order->uuid])
                ->with('success', 'Отличный выбор! Ожидайте звонка для подтверждения заказа.');

        } catch (\Throwable $e) {
            Log::error('Ошибка создания заказа: ', [
                'error' => $e->getMessage(),
                'data' => $request->validated()
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['error' => 'Произошла ошибка при оформлении заказа! Пожалуйста, попробуйте снова.']);
        }
    }

    /**
     * Рендер детальной заказа, после оформления
     *
     * @param Request $request
     * @return Response
     */
    public function show(Request $request): Response
    {
        $order = Order::byUuid($request->uuid)
            ->with('items.pizza')
            ->available()
            ->first() ?? null;

        abort_unless($order, 404);

        return Inertia::render('Order/Show', [
            'order' => $order,
        ]);
    }
}
