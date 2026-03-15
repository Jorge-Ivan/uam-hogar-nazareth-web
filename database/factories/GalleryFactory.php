<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Gallery;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Gallery>
 */
final class GalleryFactory extends Factory
{
    protected $model = Gallery::class;

    /** @return array<string, mixed> */
    public function definition(): array
    {
        $title = $this->faker->sentence(3);

        return [
            'title'       => $title,
            'slug'        => Str::slug($title),
            'description' => $this->faker->optional()->sentence(),
        ];
    }
}
