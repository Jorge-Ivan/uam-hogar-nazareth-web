<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\ContentStatus;
use App\Models\Activity;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Activity>
 */
final class ActivityFactory extends Factory
{
    protected $model = Activity::class;

    /** @return array<string, mixed> */
    public function definition(): array
    {
        $title = $this->faker->sentence(5);

        return [
            'title'             => $title,
            'slug'              => Str::slug($title),
            'excerpt'           => $this->faker->sentence(15),
            'content'           => $this->faker->paragraphs(3, true),
            'featured_image_id' => null,
            'status'            => ContentStatus::Draft,
            'published_at'      => null,
        ];
    }

    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'status'       => ContentStatus::Published,
            'published_at' => now(),
        ]);
    }

    public function archived(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => ContentStatus::Archived,
        ]);
    }
}
