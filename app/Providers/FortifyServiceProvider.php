<?php

namespace App\Providers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Auth;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('login', function (Request $request) {
        $login = (string) $request->login;

        return Limit::perMinute(10)->by(
            $login . '|' . $request->ip()
            );
        });

        Fortify::authenticateUsing(function (Request $request) {

            $request->validate([
                'login' => ['required', 'string'],
                'password' => ['required', 'string'],
            ]);

            $login = $request->login;

            $field = filter_var($login, FILTER_VALIDATE_EMAIL)
                ? 'email'
                : 'username';

            if (Auth::attempt([
                $field => $login,
                'password' => $request->password,
            ], $request->boolean('remember'))) {
                return Auth::user();
            }

            throw ValidationException::withMessages([
                'login' => ['Email / Username atau password salah.'],
            ]);
        });

        Fortify::loginView(fn () => view('auth.login'));
    }

}