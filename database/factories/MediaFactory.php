<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Media;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Media>
 */
final class MediaFactory extends Factory
{
    protected $model = Media::class;

    /** @return array<string, mixed> */
    public function definition(): array
    {
        return [
            'file_path' => 'uploads/' . Str::uuid() . '.jpg',
            'file_name' => $this->faker->word() . '.jpg',
            'mime_type' => 'image/jpeg',
            'file_size' => $this->faker->numberBetween(10000, 5000000),
            'alt_text'  => $this->faker->optional()->sentence(),
        ];
    }

    /**
     * Indicate this media record is a PDF document.
     */
    public function pdf(): static
    {
        return $this->state(fn (array $attributes) => [
            'file_path' => 'documents/' . Str::uuid() . '.pdf',
            'file_name' => $this->faker->word() . '.pdf',
            'mime_type' => 'application/pdf',
        ]);
    }
}
