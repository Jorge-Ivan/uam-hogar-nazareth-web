<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\ContentStatus;
use App\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Page>
 */
final class PageFactory extends Factory
{
    protected $model = Page::class;

    /** @return array<string, mixed> */
    public function definition(): array
    {
        $title = $this->faker->sentence(4);

        return [
            'title'          => $title,
            'slug'           => Str::slug($title),
            'content'        => $this->faker->paragraphs(3, true),
            'status'         => ContentStatus::Draft,
            'published_at'   => null,
            'parent_id'      => null,
            'show_in_header' => false,
            'show_in_footer' => false,
            'menu_order'     => 0,
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

    public function inHeader(): static
    {
        return $this->state(fn (array $attributes) => [
            'show_in_header' => true,
            'status'         => ContentStatus::Published,
            'published_at'   => now(),
        ]);
    }

    public function inFooter(): static
    {
        return $this->state(fn (array $attributes) => [
            'show_in_footer' => true,
            'status'         => ContentStatus::Published,
            'published_at'   => now(),
        ]);
    }
}
