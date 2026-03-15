<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\DocumentYear;
use App\Models\Media;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Document>
 */
final class DocumentFactory extends Factory
{
    protected $model = Document::class;

    /** @return array<string, mixed> */
    public function definition(): array
    {
        return [
            'title'                => $this->faker->sentence(4),
            'description'          => $this->faker->optional()->sentence(),
            'document_category_id' => DocumentCategory::factory(),
            'document_year_id'     => DocumentYear::factory(),
            'media_id'             => Media::factory()->pdf(),
        ];
    }
}
