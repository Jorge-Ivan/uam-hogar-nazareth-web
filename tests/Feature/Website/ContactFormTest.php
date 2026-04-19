<?php

declare(strict_types=1);

use App\Jobs\SendContactEmail;
use App\Livewire\Website\ContactForm;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Queue;
use Livewire\Livewire;

beforeEach(function (): void {
    $this->withoutVite();
});

it('does not dispatch SendContactEmail when honeypot is filled', function (): void {
    Queue::fake();

    Livewire::test(ContactForm::class)
        ->set('name', 'Bot Name')
        ->set('email', 'bot@example.com')
        ->set('message', 'spam message here spam')
        ->set('honeypot', 'filled-by-bot')
        ->call('submit');

    Queue::assertNothingPushed();
});

it('dispatches SendContactEmail with valid form data', function (): void {
    Queue::fake();
    SiteSetting::instance()->update(['mail_contact_to' => 'admin@hogarnazareth.org']);

    Livewire::test(ContactForm::class)
        ->set('name', 'Jorge Carrillo')
        ->set('email', 'jorge@example.com')
        ->set('message', 'Hola, me gustaría obtener más información.')
        ->call('submit');

    Queue::assertPushed(SendContactEmail::class);
});

it('sets sent to true after successful submission', function (): void {
    Queue::fake();
    SiteSetting::instance()->update(['mail_contact_to' => 'admin@hogarnazareth.org']);

    Livewire::test(ContactForm::class)
        ->set('name', 'Jorge Carrillo')
        ->set('email', 'jorge@example.com')
        ->set('message', 'Hola, me gustaría obtener más información sobre la fundación.')
        ->call('submit')
        ->assertSet('sent', true);
});

it('does not dispatch when mail_contact_to is not configured', function (): void {
    Queue::fake();
    SiteSetting::instance()->update(['mail_contact_to' => null]);

    Livewire::test(ContactForm::class)
        ->set('name', 'Jorge Carrillo')
        ->set('email', 'jorge@example.com')
        ->set('message', 'Hola, me gustaría obtener más información.')
        ->call('submit');

    Queue::assertNothingPushed();
});
