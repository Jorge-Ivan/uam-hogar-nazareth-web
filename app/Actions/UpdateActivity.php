<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Activity;
use App\Services\ActivityService;

final class UpdateActivity
{
    public function __construct(
        private readonly ActivityService $activityService,
    ) {}

    public function execute(Activity $activity, array $data): Activity
    {
        return $this->activityService->update($activity, $data);
    }
}
