<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Support\Facades\Http;

beforeEach(function (): void {
    $this->withoutVite();
});

it('rejects login when recaptcha token is invalid', function (): void {
    Http::fake([
        'www.google.com/recaptcha/api/siteverify' => Http::response([
            'success' => false,
            'score'   => 0.1,
        ]),
    ]);
    config(['services.recaptcha.secret_key' => 'fake-secret']);

    $user = User::factory()->create();

    $response = $this->post(route('login'), [
        'email'           => $user->email,
        'password'        => 'password',
        'recaptcha_token' => 'invalid-token',
    ]);

    $response->assertSessionHasErrors('email');
    $this->assertGuest();
});

it('allows login when recaptcha token is valid', function (): void {
    Http::fake([
        'www.google.com/recaptcha/api/siteverify' => Http::response([
            'success' => true,
            'score'   => 0.9,
            'action'  => 'login',
        ]),
    ]);
    config(['services.recaptcha.secret_key' => 'fake-secret']);

    $user = User::factory()->create();

    $response = $this->post(route('login'), [
        'email'           => $user->email,
        'password'        => 'password',
        'recaptcha_token' => 'valid-token',
    ]);

    $response->assertRedirect(route('admin.dashboard'));
    $this->assertAuthenticated();
});
