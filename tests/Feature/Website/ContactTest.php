<?php

declare(strict_types=1);

use App\Models\SiteSetting;

beforeEach(function (): void {
    $this->withoutVite();
});

it('renders contact form when mail_contact_to is configured', function (): void {
    SiteSetting::instance()->update(['mail_contact_to' => 'test@example.com']);

    $this->get(route('website.contact'))
        ->assertOk()
        ->assertSeeLivewire('website.contact-form');
});

it('shows unavailable notice when mail_contact_to is null', function (): void {
    SiteSetting::instance()->update(['mail_contact_to' => null]);

    $this->get(route('website.contact'))
        ->assertOk()
        ->assertSee('no está disponible');
});
