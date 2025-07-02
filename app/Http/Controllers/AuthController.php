<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendCodeRequest;
use App\Http\Requests\VerifyCodeRequest;
use App\Services\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function __construct(private AuthService $auth_service)
    {
    }

    /**
     * Отправка кода на почту
     *
     * @param SendCodeRequest $request
     * @return void
     */
    public function sendCode(SendCodeRequest $request): void
    {
        $this->auth_service->sendVerificationCode($request->validated('email'));
    }

    /**
     * Подтверждение кода и авторизация
     *
     * @param VerifyCodeRequest $request
     * @return RedirectResponse|Response
     */
    public function verifyCode(VerifyCodeRequest $request): RedirectResponse|Response
    {
        $user = $this->auth_service->verifyCodeAndLogin(
            $request->validated('email'),
            $request->validated('code')
        );

        if (!$user) {
            return redirect()
                ->back()
                ->withErrors(['error' => 'Ошибка входа в аккаунт! Неверный или просроченный код.']);
        }

        return Inertia::location(route('home'));
    }

    /**
     * Выход
     *
     * @param Request $request
     * @return Response
     */
    public function logout(Request $request): Response
    {
        $this->auth_service->logout($request);

        return Inertia::location(route('home'));
    }
}
