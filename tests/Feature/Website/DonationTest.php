<?php

declare(strict_types=1);

use App\Models\Media;
use App\Models\SiteSetting;

beforeEach(function (): void {
    $this->withoutVite();
});

it('shows bank info when configured', function (): void {
    SiteSetting::instance()->update(['donation_bank_name' => 'Bancolombia']);

    $this->get(route('website.donations'))->assertOk()->assertSee('Bancolombia');
});

it('shows fallback when all donation fields are null', function (): void {
    SiteSetting::instance()->update([
        'donation_bank_name'  => null,
        'donation_account'    => null,
        'donation_nequi'      => null,
        'donation_daviplata'  => null,
    ]);

    $this->get(route('website.donations'))->assertOk()->assertSee('contáctenos');
});

it('shows nequi section when nequi number is configured', function (): void {
    SiteSetting::instance()->update(['donation_nequi' => '3001234567']);

    $this->get(route('website.donations'))->assertOk()->assertSee('3001234567');
});

it('shows qr image when donation_qr_media_id is configured', function (): void {
    $media = Media::factory()->create();
    SiteSetting::instance()->update(['donation_qr_media_id' => $media->id]);

    $this->get(route('website.donations'))->assertOk();
});
