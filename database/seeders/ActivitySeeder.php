<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\ContentStatus;
use App\Models\Activity;
use Illuminate\Database\Seeder;

final class ActivitySeeder extends Seeder
{
    public function run(): void
    {
        $activities = [
            [
                'title'        => 'Terapia física grupal',
                'slug'         => 'terapia-fisica-grupal',
                'excerpt'      => 'Rutinas suaves de movilidad articular y equilibrio, guiadas por nuestra fisioterapeuta tres veces por semana.',
                'content'      => '<p>Las sesiones de terapia física son uno de los pilares del bienestar en el Fundación Centro de Bienestar del Anciano Nazareth. Cada rutina dura 45 minutos y está diseñada por nuestra fisioterapeuta Mónica Salazar para adaptarse a las condiciones de cada residente.</p><p>Trabajamos movilidad de hombros, caderas y tobillos, ejercicios de fuerza con bandas elásticas y cerramos con estiramiento y relajación guiada. Las personas con movilidad reducida cuentan con variantes adaptadas desde la silla.</p>',
                'status'       => ContentStatus::Published,
                'published_at' => now()->subDays(3),
            ],
            [
                'title'        => 'Musicoterapia: tardes de carrilera',
                'slug'         => 'musicoterapia-tardes-carrilera',
                'excerpt'      => 'Cada jueves nos reunimos a cantar boleros, carrilera y música parrandera. Panderetica, voz y mucho corazón.',
                'content'      => '<p>La música tiene un poder especial para despertar la memoria y el buen humor. Todos los jueves en la tarde, el salón comunal se convierte en escenario de boleros, rancheras y música parrandera colombiana.</p><p>Los residentes cantan, tocan pandereta, tararean y en ocasiones se animan a bailar. Es uno de los momentos más alegres de la semana y cuenta siempre con la participación de familiares y voluntarios.</p>',
                'status'       => ContentStatus::Published,
                'published_at' => now()->subDays(7),
            ],
            [
                'title'        => 'Taller de tejido y manualidades',
                'slug'         => 'taller-tejido-manualidades',
                'excerpt'      => 'Bufandas, cojines y ruanas hechos a dos agujas. Parte de las piezas se vende cada año en el bazar.',
                'content'      => '<p>El taller de tejido se reúne todos los martes en la mañana. Con agujas, lana y mucha paciencia, nuestros residentes crean piezas que luego se venden en el bazar anual para contribuir al sostenimiento del hogar.</p><p>También hacemos flores de papel, tarjetas para fechas especiales y decoraciones para las celebraciones del mes. El trabajo manual favorece la concentración, la motricidad fina y la autoestima.</p>',
                'status'       => ContentStatus::Published,
                'published_at' => now()->subDays(12),
            ],
            [
                'title'        => 'Eucaristía semanal',
                'slug'         => 'eucaristia-semanal',
                'excerpt'      => 'Celebración dominical en la capilla del hogar, abierta a familias y comunidad.',
                'content'      => '<p>Cada domingo se celebra la eucaristía en la pequeña capilla del hogar, presidida por el padre acompañante de la parroquia local. La misa es abierta a familiares de los residentes y a miembros de la comunidad que quieran acompañar.</p><p>La fe es un sostén fundamental para muchos de nuestros adultos mayores. El acompañamiento espiritual hace parte del cuidado integral que ofrecemos.</p>',
                'status'       => ContentStatus::Published,
                'published_at' => now()->subDays(18),
            ],
            [
                'title'        => 'Paseo al malecón del río Risaralda',
                'slug'         => 'paseo-malecon-rio-risaralda',
                'excerpt'      => 'Caminata asistida por la ribera del río Risaralda. Helado, brisa y conversa larga.',
                'content'      => '<p>Una vez al mes organizamos una salida al malecón del río Risaralda. Con la ayuda de voluntarios y el equipo del hogar, los residentes que pueden caminar —o ir en silla de ruedas— disfrutan del paisaje, el aire fresco y un helado obligatorio al final del recorrido.</p><p>Estas salidas son muy importantes para mantener el vínculo con el mundo exterior y para la salud mental de nuestros adultos mayores.</p>',
                'status'       => ContentStatus::Published,
                'published_at' => now()->subDays(25),
            ],
            [
                'title'        => 'Estimulación cognitiva',
                'slug'         => 'estimulacion-cognitiva',
                'excerpt'      => 'Crucigramas, memoria visual y conversación dirigida en grupos pequeños los martes y jueves.',
                'content'      => '<p>La estimulación cognitiva busca mantener activas las funciones mentales: memoria, atención, lenguaje y pensamiento. Los ejercicios incluyen crucigramas adaptados, juegos de memoria visual, lectura comentada y conversación dirigida sobre temas de actualidad o historia.</p><p>Se trabaja en grupos pequeños de cuatro a seis personas para que cada sesión sea personalizada y participativa.</p>',
                'status'       => ContentStatus::Published,
                'published_at' => now()->subDays(30),
            ],
            [
                'title'        => 'Jardinería: la huerta del hogar',
                'slug'         => 'jardineria-huerta-hogar',
                'excerpt'      => 'Cilantro, hierbabuena, zábila y plantas de jardín. Los residentes cuidan su pequeño huerto cada mañana.',
                'content'      => '<p>En el patio trasero del hogar tenemos una pequeña huerta que los residentes cuidan con mucho orgullo. Cilantro, hierbabuena, zábila, albahaca y varias matas de flores son atendidas cada mañana por quienes gustan de las labores al aire libre.</p><p>La jardinería reduce el estrés, favorece el ejercicio suave y da sentido de responsabilidad y logro a quienes participan.</p>',
                'status'       => ContentStatus::Published,
                'published_at' => now()->subDays(40),
            ],
            [
                'title'        => 'Cine de los sábados',
                'slug'         => 'cine-de-los-sabados',
                'excerpt'      => 'Películas mexicanas clásicas, crispetas y un comentario post-función obligatorio todos los sábados a las 3 pm.',
                'content'      => '<p>Los sábados a las 3 de la tarde se proyecta una película en el salón principal. El repertorio incluye clásicos del cine mexicano —Pedro Infante, Jorge Negrete, María Félix— aunque también hay espacio para comedias colombianas y películas de aventura.</p><p>El debate post-película es tan importante como la función misma: los residentes comentan, opinan, recuerdan otras películas y comparten anécdotas. Las crispetas son parte del protocolo y no se negocian.</p>',
                'status'       => ContentStatus::Published,
                'published_at' => now()->subDays(50),
            ],
        ];

        foreach ($activities as $data) {
            Activity::updateOrCreate(['slug' => $data['slug']], $data);
        }
    }
}
