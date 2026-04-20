<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Gallery;
use Illuminate\Database\Seeder;

final class GallerySeeder extends Seeder
{
    public function run(): void
    {
        $galleries = [
            [
                'title'       => 'Bazar Navideño 2024',
                'slug'        => 'bazar-navideno-2024',
                'description' => '15 de noviembre de 2024. Un día de manualidades, música, comida típica y mucho amor compartido con la comunidad.',
            ],
            [
                'title'       => 'Día de la madre 2025',
                'slug'        => 'dia-de-la-madre-2025',
                'description' => 'Celebración del día de la madre con nuestras residentes. Flores, música en vivo y un sancocho preparado con todo el cariño.',
            ],
            [
                'title'       => 'Terapia física y actividades 2025',
                'slug'        => 'terapia-fisica-actividades-2025',
                'description' => 'Momentos de nuestras sesiones de fisioterapia, musicoterapia y taller de tejido durante el primer semestre de 2025.',
            ],
            [
                'title'       => 'Paseo al malecón',
                'slug'        => 'paseo-malecon',
                'description' => 'Salida mensual al malecón del río Risaralda. Brisa, helado y conversa larga con los residentes.',
            ],
            [
                'title'       => 'Novena de aguinaldos 2024',
                'slug'        => 'novena-aguinaldos-2024',
                'description' => 'Nueve noches de villancicos, natilla y el acompañamiento de más de 200 vecinos.',
            ],
        ];

        foreach ($galleries as $data) {
            Gallery::updateOrCreate(['slug' => $data['slug']], $data);
        }
    }
}
