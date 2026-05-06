<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\ContentStatus;
use App\Models\Page;
use Illuminate\Database\Seeder;

final class PageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'title'          => 'Quiénes somos',
                'slug'           => 'quienes-somos',
                'content'        => '<p>La Fundación Centro de Bienestar del Anciano Nazareth es una institución sin ánimo de lucro ubicada en La Virginia, Risaralda, Colombia. Fue fundada hace más de 26 años con la misión de brindar cuidado, acompañamiento y dignidad a personas adultas mayores que requieren atención especializada.</p><p>Contamos con un equipo interdisciplinario de profesionales en salud, trabajo social y animación sociocultural, comprometidos con el bienestar integral de cada residente.</p>',
                'status'         => ContentStatus::Published,
                'published_at'   => now(),
                'show_in_header' => true,
                'show_in_footer' => true,
                'menu_order'     => 1,
            ],
            [
                'title'          => 'Misión y Visión',
                'slug'           => 'mision-vision',
                'content'        => '<h2>Misión</h2><p>Brindar atención integral, digna y humana a las personas adultas mayores que lo necesiten, mediante servicios de salud, recreación, espiritualidad y convivencia, con el apoyo de la comunidad y las familias.</p><h2>Visión</h2><p>Ser reconocidos en el departamento de Risaralda como la institución de referencia en el cuidado y bienestar del adulto mayor, con altos estándares de calidad humana y ética institucional.</p>',
                'status'         => ContentStatus::Published,
                'published_at'   => now(),
                'show_in_header' => false,
                'show_in_footer' => true,
                'menu_order'     => 2,
            ],
            [
                'title'          => 'Nuestros servicios',
                'slug'           => 'servicios',
                'content'        => '<p>Ofrecemos atención integral a nuestros residentes a través de los siguientes servicios:</p><ul><li><strong>Fisioterapia:</strong> sesiones grupales e individuales de movilidad y rehabilitación.</li><li><strong>Estimulación cognitiva:</strong> actividades diseñadas para mantener activa la memoria y el pensamiento.</li><li><strong>Atención médica:</strong> control periódico de salud, seguimiento de tratamientos y acompañamiento en urgencias.</li><li><strong>Trabajo social:</strong> apoyo a familias en el proceso de ingreso y seguimiento del bienestar del residente.</li><li><strong>Actividades recreativas:</strong> música, manualidades, jardinería, salidas y celebraciones especiales.</li><li><strong>Acompañamiento espiritual:</strong> eucaristía semanal, grupos de oración y momentos de reflexión.</li></ul>',
                'status'         => ContentStatus::Published,
                'published_at'   => now(),
                'show_in_header' => true,
                'show_in_footer' => true,
                'menu_order'     => 3,
            ],
            [
                'title'          => 'Cómo ingresar',
                'slug'           => 'como-ingresar',
                'content'        => '<p>El proceso de ingreso al Fundación Centro de Bienestar del Anciano Nazareth se realiza a través de trabajo social. El primer paso es contactarnos para agendar una visita de valoración.</p><h3>Requisitos generales</h3><ul><li>Copia del documento de identidad del adulto mayor.</li><li>Historia clínica reciente.</li><li>Documento de identidad del familiar responsable.</li><li>Carta de compromiso familiar.</li></ul><p>Una vez recibida la solicitud, nuestro equipo realiza una valoración integral para determinar el nivel de cuidado requerido y la disponibilidad de cupo.</p>',
                'status'         => ContentStatus::Published,
                'published_at'   => now(),
                'show_in_header' => true,
                'show_in_footer' => false,
                'menu_order'     => 4,
            ],
        ];

        foreach ($pages as $data) {
            Page::updateOrCreate(['slug' => $data['slug']], $data);
        }
    }
}
