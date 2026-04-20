<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            SiteSettingSeeder::class,
            DocumentCategorySeeder::class,
            DocumentYearSeeder::class,
            PageSeeder::class,
            ActivitySeeder::class,
            EventSeeder::class,
            GallerySeeder::class,
            DocumentSeeder::class,
        ]);
    }
}
