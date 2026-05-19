<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Event;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

final class EventService
{
    public function create(array $data): Event
    {
        $data['slug'] = $data['slug'] ?? Str::slug($data['title']);
        $event = Event::create($data);
        Cache::forget('sitemap.xml');

        return $event;
    }

    public function update(Event $event, array $data): Event
    {
        if (isset($data['title']) && ! isset($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        $event->update($data);
        Cache::forget('sitemap.xml');

        return $event->fresh();
    }

    /**
     * Permanently delete an event record.
     */
    public function delete(Event $event): void
    {
        $event->delete();
        Cache::forget('sitemap.xml');
    }
}
