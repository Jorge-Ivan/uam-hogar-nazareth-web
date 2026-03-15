<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Event;
use App\Services\EventService;

final class UpdateEvent
{
    public function __construct(
        private readonly EventService $eventService,
    ) {}

    public function execute(Event $event, array $data): Event
    {
        return $this->eventService->update($event, $data);
    }
}
