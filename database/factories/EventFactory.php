<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Event>
 */
final class EventFactory extends Factory
{
    protected $model = Event::class;

    /** @return array<string, mixed> */
    public function definition(): array
    {
        $title = $this->faker->sentence(4);
        $startDate = $this->faker->dateTimeBetween('now', '+6 months');

        return [
            'title'             => $title,
            'slug'              => Str::slug($title),
            'description'       => $this->faker->optional()->paragraph(),
            'start_date'        => $startDate,
            'end_date'          => $this->faker->optional()->dateTimeBetween($startDate, '+1 year'),
            'location'          => $this->faker->optional()->city(),
            'featured_image_id' => null,
        ];
    }

    public function upcoming(): static
    {
        return $this->state(fn (array $attributes) => [
            'start_date' => now()->addDays(7),
            'end_date'   => now()->addDays(8),
        ]);
    }

    public function past(): static
    {
        return $this->state(fn (array $attributes) => [
            'start_date' => now()->subDays(30),
            'end_date'   => now()->subDays(29),
        ]);
    }
}
