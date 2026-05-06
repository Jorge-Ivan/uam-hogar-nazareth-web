<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\ContentStatus;
use App\Models\Activity;
use App\Models\Media;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

final class ActivityService
{
    public function create(array $data): Activity
    {
        $data['slug']   = $data['slug'] ?? Str::slug($data['title']);
        $data['status'] = $data['status'] ?? ContentStatus::Draft;

        return Activity::create($data);
    }

    public function update(Activity $activity, array $data): Activity
    {
        if (isset($data['title']) && ! isset($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        $activity->update($data);

        Cache::forget('website.home.activities');

        return $activity->fresh();
    }

    public function publish(Activity $activity): Activity
    {
        $activity->update([
            'status'       => ContentStatus::Published,
            'published_at' => now(),
        ]);

        Cache::forget('website.home.activities');

        return $activity->fresh();
    }

    public function archive(Activity $activity): Activity
    {
        $activity->update(['status' => ContentStatus::Archived]);

        Cache::forget('website.home.activities');

        return $activity->fresh();
    }

    public function setFeaturedImage(Activity $activity, Media $media): Activity
    {
        $activity->update(['featured_image_id' => $media->id]);

        return $activity->fresh();
    }

    public function delete(Activity $activity): void
    {
        $activity->delete();

        Cache::forget('website.home.activities');
    }
}
