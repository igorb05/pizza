<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Рендер страницы редактирования профиля
     *
     * @return Response
     */
    public function edit(): Response
    {
        return Inertia::render('Profile/Edit', [
            'user' => auth()->user(),
        ]);
    }

    /**
     * Обновление данных профиля
     *
     * @param UpdateProfileRequest $request
     * @return RedirectResponse
     */
    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $user = auth()->user();

        $user->fill($request->validated());

        if (!$user->isDirty()) {
            return back()->with('info', 'Нет изменений для сохранения.');
        }

        try {
            $user->save();

            return back()->with('success', 'Данные профиля обновлены!');

        } catch (\Throwable $e) {
            Log::error('Ошибка обновления профиля пользователя', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'data' => $request->validated()
            ]);

            return back()->withErrors(['error' => 'Не удалось обновить данные профиля']);
        }
    }


    /**
     * Вывод заказов пользователя
     *
     * @return Response
     */
    public function orders(): Response
    {
        return Inertia::render('Profile/Orders/Index', [
            'orders' => auth()?->user()->orders()->with('items.pizza')->latest()->get() ?? null,
        ]);
    }
}
