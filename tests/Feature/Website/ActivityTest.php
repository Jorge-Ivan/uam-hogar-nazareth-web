<?php

declare(strict_types=1);

use App\Enums\ContentStatus;
use App\Models\Activity;

beforeEach(function (): void {
    $this->withoutVite();
});

it('shows only published activities on index', function (): void {
    $draft     = Activity::factory()->create(['status' => ContentStatus::Draft]);
    $published = Activity::factory()->create([
        'status'       => ContentStatus::Published,
        'published_at' => now(),
    ]);

    $this->get(route('website.activities.index'))
        ->assertOk()
        ->assertSee($published->title)
        ->assertDontSee($draft->title);
});

it('returns 404 for draft activity slug', function (): void {
    Activity::factory()->create([
        'status' => ContentStatus::Draft,
        'slug'   => 'draft-activity',
    ]);

    $this->get(route('website.activities.show', 'draft-activity'))->assertNotFound();
});

it('returns 200 for published activity', function (): void {
    $activity = Activity::factory()->create([
        'status'       => ContentStatus::Published,
        'published_at' => now(),
    ]);

    $this->get(route('website.activities.show', $activity->slug))
        ->assertOk()
        ->assertSee($activity->title);
});
