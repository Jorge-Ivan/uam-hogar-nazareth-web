<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\DocumentCategory;
use Illuminate\Database\Seeder;

class DocumentCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Registro DIAN / RUT',    'slug' => 'registro-dian-rut'],
            ['name' => 'Estatutos',               'slug' => 'estatutos'],
            ['name' => 'Personería Jurídica',     'slug' => 'personeria-juridica'],
            ['name' => 'Actas de Asamblea',       'slug' => 'actas-de-asamblea'],
            ['name' => 'Informes de Gestión',     'slug' => 'informes-de-gestion'],
            ['name' => 'Estados Financieros',     'slug' => 'estados-financieros'],
            ['name' => 'Informes de Auditoría',   'slug' => 'informes-de-auditoria'],
            ['name' => 'Certificados',            'slug' => 'certificados'],
            ['name' => 'Política de Datos',       'slug' => 'politica-de-datos'],
            ['name' => 'Otro',                    'slug' => 'otro'],
        ];

        foreach ($categories as $category) {
            DocumentCategory::updateOrCreate(
                ['slug' => $category['slug']],
                ['name' => $category['name']],
            );
        }
    }
}
