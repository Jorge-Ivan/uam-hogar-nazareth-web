<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Activity;
use App\Services\ActivityService;

final class CreateActivity
{
    public function __construct(
        private readonly ActivityService $activityService,
    ) {}

    public function execute(array $data): Activity
    {
        return $this->activityService->create($data);
    }
}
