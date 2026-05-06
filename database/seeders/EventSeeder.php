<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;

final class EventSeeder extends Seeder
{
    public function run(): void
    {
        $events = [
            // Próximos
            [
                'title'       => 'Bazar Navideño Nazareth 2026',
                'slug'        => 'bazar-navideno-nazareth-2026',
                'description' => 'Nuestra jornada anual más esperada. Ventas de manualidades hechas por los residentes, platos típicos preparados por las familias voluntarias, rifa con premios donados y presentación de la agrupación musical del hogar. Entrada libre y familia invitada.',
                'start_date'  => now()->addMonths(2)->startOfDay(),
                'end_date'    => null,
                'location'    => 'Parque principal · La Virginia, Risaralda',
            ],
            [
                'title'       => 'Jornada de voluntariado y donación en especie',
                'slug'        => 'jornada-voluntariado-donacion-especie-2026',
                'description' => 'Abre las puertas del hogar para que la comunidad conozca nuestras instalaciones, interactúe con los residentes y done elementos de primera necesidad: ropa, calzado, productos de aseo personal y alimentos no perecederos.',
                'start_date'  => now()->addWeeks(3)->startOfDay(),
                'end_date'    => null,
                'location'    => 'Fundación Centro de Bienestar del Anciano Nazareth · Calle 8 # 12-45, La Virginia',
            ],
            [
                'title'       => 'Caminata del abrazo',
                'slug'        => 'caminata-del-abrazo-2026',
                'description' => 'Caminata familiar de 2 km para recaudar fondos. Inscripción simbólica de $15.000. Todo lo recaudado va al fondo de alimentación de los residentes.',
                'start_date'  => now()->addWeeks(6)->startOfDay(),
                'end_date'    => null,
                'location'    => 'Malecón río Risaralda',
            ],
            // Pasados
            [
                'title'       => 'Día de la madre 2025',
                'slug'        => 'dia-de-la-madre-2025',
                'description' => 'Sancocho, música en vivo y regalos hechos a mano para cada una de nuestras residentes. Una tarde llena de flores, abrazos y lágrimas de alegría.',
                'start_date'  => now()->subMonths(2)->startOfDay(),
                'end_date'    => null,
                'location'    => 'Fundación Centro de Bienestar del Anciano Nazareth',
            ],
            [
                'title'       => 'Novena de aguinaldos 2024',
                'slug'        => 'novena-aguinaldos-2024',
                'description' => 'Nueve noches abiertas a la comunidad. Villancicos, chocolate, natilla y el acompañamiento de más de 200 vecinos y familias. Una de las celebraciones más queridas del año.',
                'start_date'  => now()->subMonths(5)->startOfDay(),
                'end_date'    => now()->subMonths(4)->startOfDay(),
                'location'    => 'Capilla del hogar',
            ],
            [
                'title'       => 'Bazar Nazareth 2024',
                'slug'        => 'bazar-nazareth-2024',
                'description' => 'Recaudamos más de $38 millones gracias a la generosidad de la comunidad. Gracias a cada persona que compró, donó o solo pasó a saludar. El bazar 2024 fue un éxito rotundo.',
                'start_date'  => now()->subMonths(6)->startOfDay(),
                'end_date'    => null,
                'location'    => 'Parque principal · La Virginia',
            ],
            [
                'title'       => 'Eucaristía de aniversario — 26 años',
                'slug'        => 'eucaristia-aniversario-26-anos',
                'description' => '26 años de la fundación celebrados con las familias, exresidentes y padrinos. Una eucaristía de acción de gracias seguida de un almuerzo comunitario.',
                'start_date'  => now()->subMonths(10)->startOfDay(),
                'end_date'    => null,
                'location'    => 'Capilla del hogar',
            ],
        ];

        foreach ($events as $data) {
            Event::updateOrCreate(['slug' => $data['slug']], $data);
        }
    }
}
