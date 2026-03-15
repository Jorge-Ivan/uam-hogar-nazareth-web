<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Event;
use Illuminate\Support\Str;

final class EventService
{
    public function create(array $data): Event
    {
        $data['slug'] = $data['slug'] ?? Str::slug($data['title']);

        return Event::create($data);
    }

    public function update(Event $event, array $data): Event
    {
        if (isset($data['title']) && ! isset($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        $event->update($data);

        return $event->fresh();
    }
}
