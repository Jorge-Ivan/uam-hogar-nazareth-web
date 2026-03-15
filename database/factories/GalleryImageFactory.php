<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Gallery;
use App\Models\GalleryImage;
use App\Models\Media;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<GalleryImage>
 */
final class GalleryImageFactory extends Factory
{
    protected $model = GalleryImage::class;

    /** @return array<string, mixed> */
    public function definition(): array
    {
        return [
            'gallery_id' => Gallery::factory(),
            'media_id'   => Media::factory(),
            'caption'    => $this->faker->optional()->sentence(),
            'position'   => $this->faker->numberBetween(1, 100),
        ];
    }
}
