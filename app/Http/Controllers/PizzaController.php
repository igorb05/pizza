<?php

namespace App\Http\Controllers;

use App\Models\Pizza;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

class PizzaController extends Controller
{
    /**
     * Поиск
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request): JsonResponse
    {
        $query = $request->string('query');

        $pizzas = Pizza::where('name', 'ILIKE', "%{$query}%")
            ->limit(5)
            ->get();

        return response()->json($pizzas);
    }

    /**
     * Вывод и фильтрация всех пицц
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function pizzas(Request $request): JsonResponse
    {
        $sort = $request->input('sort', 'default');
        $asc = $request->integer('asc');
        $desc = $request->integer('desc');
        $ingredients = $request->array('ingredients');

        $query = Pizza::query();

        // фильтр по цене
        $query->when($asc, fn($q) => $q->where('price', '>=', $asc))
            ->when($desc, fn($q) => $q->where('price', '<=', $desc));

        // фильтр по ингредиентам
        if ($ingredients) {
            foreach ($ingredients as $ingredient) {
                $query->where('description', 'ILIKE', "%{$ingredient}%");
            }
        }

        // сортировка
        match ($sort) {
            'asc' => $query->orderBy('price'),
            'desc' => $query->orderBy('price', 'desc'),
            default => $query->orderBy('id')
        };

        return response()->json($query->get());
    }
}
