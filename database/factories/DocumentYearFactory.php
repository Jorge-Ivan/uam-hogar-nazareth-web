<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\DocumentYear;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DocumentYear>
 */
final class DocumentYearFactory extends Factory
{
    protected $model = DocumentYear::class;

    /** @return array<string, mixed> */
    public function definition(): array
    {
        return [
            'year' => $this->faker->unique()->year(),
        ];
    }
}
