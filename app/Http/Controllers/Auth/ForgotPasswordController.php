<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

/**
 * Handles sending password reset links via email.
 */
final class ForgotPasswordController extends Controller
{
    /**
     * Show the forgot-password form.
     */
    public function showLinkRequestForm(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Send a password reset link to the given email address.
     */
    public function sendResetLinkEmail(Request $request): RedirectResponse
    {
        $request->validate(
            ['email' => ['required', 'email']],
            ['email.required' => 'El correo electrónico es obligatorio.',
             'email.email'    => 'Ingresa un correo electrónico válido.'],
        );

        $status = Password::sendResetLink($request->only('email'));

        // Always show a success-like message to avoid user enumeration.
        if ($status === Password::RESET_LINK_SENT) {
            return back()->with(
                'status',
                'Si ese correo está registrado, recibirás un enlace para restablecer tu contraseña.'
            );
        }

        return back()->with(
            'status',
            'Si ese correo está registrado, recibirás un enlace para restablecer tu contraseña.'
        );
    }
}
