<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\View\View;

/**
 * Handles resetting the user's password via a signed token.
 */
final class ResetPasswordController extends Controller
{
    /**
     * Show the reset-password form.
     */
    public function showResetForm(Request $request, string $token): View
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email', ''),
        ]);
    }

    /**
     * Reset the user's password.
     */
    public function reset(Request $request): RedirectResponse
    {
        $request->validate(
            [
                'token'                 => ['required'],
                'email'                 => ['required', 'email'],
                'password'              => ['required', 'confirmed', 'min:8'],
            ],
            [
                'email.required'              => 'El correo electrónico es obligatorio.',
                'email.email'                 => 'Ingresa un correo electrónico válido.',
                'password.required'           => 'La contraseña es obligatoria.',
                'password.confirmed'          => 'Las contraseñas no coinciden.',
                'password.min'               => 'La contraseña debe tener al menos 8 caracteres.',
            ],
        );

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, string $password): void {
                $user->forceFill([
                    'password'       => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()
                ->route('login')
                ->with('status', 'Contraseña restablecida correctamente. Inicia sesión.');
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => __($status)]);
    }
}
