<?php

declare(strict_types=1);

use App\Enums\UserRole;
use App\Models\Activity;
use App\Models\Document;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\Page;
use App\Models\User;
use App\Policies\ActivityPolicy;
use App\Policies\DocumentPolicy;
use App\Policies\EventPolicy;
use App\Policies\GalleryPolicy;
use App\Policies\PagePolicy;

// ─── Helpers ────────────────────────────────────────────────────────────────

function adminUser(): User
{
    return User::factory()->create(['role' => UserRole::Admin]);
}

function editorUser(): User
{
    return User::factory()->create(['role' => UserRole::Editor]);
}

// ─── PagePolicy ─────────────────────────────────────────────────────────────

describe('PagePolicy', function (): void {
    it('allows both roles to create and update pages', function (): void {
        $policy = new PagePolicy();
        $page   = Page::factory()->create();

        expect($policy->create(adminUser()))->toBeTrue()
            ->and($policy->create(editorUser()))->toBeTrue()
            ->and($policy->update(adminUser(), $page))->toBeTrue()
            ->and($policy->update(editorUser(), $page))->toBeTrue();
    });

    it('allows editor to publish, archive, and delete pages', function (): void {
        $policy = new PagePolicy();
        $page   = Page::factory()->create();
        $editor = editorUser();

        expect($policy->publish($editor, $page))->toBeTrue()
            ->and($policy->archive($editor, $page))->toBeTrue()
            ->and($policy->delete($editor, $page))->toBeTrue();
    });

    it('allows admin to publish, archive, and delete pages', function (): void {
        $policy = new PagePolicy();
        $page   = Page::factory()->create();
        $admin  = adminUser();

        expect($policy->publish($admin, $page))->toBeTrue()
            ->and($policy->archive($admin, $page))->toBeTrue()
            ->and($policy->delete($admin, $page))->toBeTrue();
    });
});

// ─── ActivityPolicy ──────────────────────────────────────────────────────────

describe('ActivityPolicy', function (): void {
    it('allows both roles to create and update activities', function (): void {
        $policy   = new ActivityPolicy();
        $activity = Activity::factory()->create();

        expect($policy->create(adminUser()))->toBeTrue()
            ->and($policy->create(editorUser()))->toBeTrue()
            ->and($policy->update(adminUser(), $activity))->toBeTrue()
            ->and($policy->update(editorUser(), $activity))->toBeTrue();
    });

    it('allows editor to publish, archive, and delete activities', function (): void {
        $policy   = new ActivityPolicy();
        $activity = Activity::factory()->create();
        $editor   = editorUser();

        expect($policy->publish($editor, $activity))->toBeTrue()
            ->and($policy->archive($editor, $activity))->toBeTrue()
            ->and($policy->delete($editor, $activity))->toBeTrue();
    });

    it('allows admin to publish, archive, and delete activities', function (): void {
        $policy   = new ActivityPolicy();
        $activity = Activity::factory()->create();
        $admin    = adminUser();

        expect($policy->publish($admin, $activity))->toBeTrue()
            ->and($policy->archive($admin, $activity))->toBeTrue()
            ->and($policy->delete($admin, $activity))->toBeTrue();
    });
});

// ─── GalleryPolicy ───────────────────────────────────────────────────────────

describe('GalleryPolicy', function (): void {
    it('allows both roles to manage gallery images', function (): void {
        $policy  = new GalleryPolicy();
        $gallery = Gallery::factory()->create();

        expect($policy->create(adminUser()))->toBeTrue()
            ->and($policy->create(editorUser()))->toBeTrue()
            ->and($policy->addImage(adminUser(), $gallery))->toBeTrue()
            ->and($policy->addImage(editorUser(), $gallery))->toBeTrue()
            ->and($policy->removeImage(editorUser(), $gallery))->toBeTrue()
            ->and($policy->reorder(editorUser(), $gallery))->toBeTrue();
    });

    it('allows editor to delete a gallery', function (): void {
        $policy  = new GalleryPolicy();
        $gallery = Gallery::factory()->create();
        $editor  = editorUser();

        expect($policy->delete($editor, $gallery))->toBeTrue();
    });

    it('allows admin to delete a gallery', function (): void {
        $policy  = new GalleryPolicy();
        $gallery = Gallery::factory()->create();
        $admin   = adminUser();

        expect($policy->delete($admin, $gallery))->toBeTrue();
    });
});

// ─── EventPolicy ─────────────────────────────────────────────────────────────

describe('EventPolicy', function (): void {
    it('allows both roles to create and update events', function (): void {
        $policy = new EventPolicy();
        $event  = Event::factory()->create();

        expect($policy->create(adminUser()))->toBeTrue()
            ->and($policy->create(editorUser()))->toBeTrue()
            ->and($policy->update(adminUser(), $event))->toBeTrue()
            ->and($policy->update(editorUser(), $event))->toBeTrue();
    });

    it('allows editor to delete events', function (): void {
        $policy = new EventPolicy();
        $event  = Event::factory()->create();
        $editor = editorUser();

        expect($policy->delete($editor, $event))->toBeTrue();
    });

    it('allows admin to delete events', function (): void {
        $policy = new EventPolicy();
        $event  = Event::factory()->create();
        $admin  = adminUser();

        expect($policy->delete($admin, $event))->toBeTrue();
    });
});

// ─── DocumentPolicy ──────────────────────────────────────────────────────────

describe('DocumentPolicy', function (): void {
    it('allows both roles to create and update documents', function (): void {
        $policy   = new DocumentPolicy();
        $document = Document::factory()->create();

        expect($policy->create(adminUser()))->toBeTrue()
            ->and($policy->create(editorUser()))->toBeTrue()
            ->and($policy->update(adminUser(), $document))->toBeTrue()
            ->and($policy->update(editorUser(), $document))->toBeTrue();
    });

    it('allows editor to delete documents', function (): void {
        $policy   = new DocumentPolicy();
        $document = Document::factory()->create();
        $editor   = editorUser();

        expect($policy->delete($editor, $document))->toBeTrue();
    });

    it('allows admin to delete documents', function (): void {
        $policy   = new DocumentPolicy();
        $document = Document::factory()->create();
        $admin    = adminUser();

        expect($policy->delete($admin, $document))->toBeTrue();
    });
});
