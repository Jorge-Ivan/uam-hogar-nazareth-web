<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\DocumentYear;
use Illuminate\Database\Seeder;

final class DocumentYearSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([2022, 2023, 2024, 2025] as $year) {
            DocumentYear::firstOrCreate(['year' => $year]);
        }
    }
}
