<?php

namespace App\Services;

use App\Models\Email;
use App\Models\User;
use App\Notifications\CodeNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class AuthService
{
    private const CODE_EXPIRY_MINUTES = 15;

    /**
     * @param string $email
     * @return void
     */
    public function sendVerificationCode(string $email): void
    {
        DB::transaction(function () use ($email) {
            // удаляем старые коды для этого Email
            Email::where('email', $email)->delete();

            $code = random_int(100000, 999999);

            Email::create([
                'email' => $email,
                'code' => $code,
                'expires_at' => now()->addMinutes(self::CODE_EXPIRY_MINUTES),
            ]);

            Notification::route('mail', $email)
                ->notify(new CodeNotification($code));
        });
    }

    /**
     * @param string $email
     * @param string $code
     * @return User|null
     */
    public function verifyCodeAndLogin(string $email, string $code): ?User
    {
        return DB::transaction(function () use ($email, $code) {
            $login_code = Email::where('email', $email)
                ->where('code', $code)
                ->where('expires_at', '>', now())
                ->first();

            if (!$login_code) {
                return null;
            }

            $user = User::firstOrCreate(['email' => $email]);

            auth()->login($user);

            $login_code->delete();

            return $user;
        });
    }

    /**
     * @param Request $request
     * @return void
     */
    public function logout(Request $request): void
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }
}
