<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Activity;
use App\Models\Media;
use App\Services\ActivityService;

final class SetActivityFeaturedImage
{
    public function __construct(
        private readonly ActivityService $activityService,
    ) {}

    public function execute(Activity $activity, Media $media): Activity
    {
        return $this->activityService->setFeaturedImage($activity, $media);
    }
}
