<?php

declare(strict_types=1);

it('renders the 503 view with expected content', function (): void {
    $view = view('errors.503')->render();

    expect($view)
        ->toContain('Estamos renovando')
        ->toContain('Fundación Centro de Bienestar del Anciano Nazareth')
        ->toContain('Próximamente')
        ->toContain('Facebook');
});

it('renders the 503 view with valid html structure', function (): void {
    $view = view('errors.503')->render();

    expect($view)
        ->toContain('<html lang="es">')
        ->toContain('--nz-blue')
        ->toContain('logo_fundacion_isotipo-2.png');
});
