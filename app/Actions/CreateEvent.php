<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Event;
use App\Services\EventService;

final class CreateEvent
{
    public function __construct(
        private readonly EventService $eventService,
    ) {}

    public function execute(array $data): Event
    {
        return $this->eventService->create($data);
    }
}
