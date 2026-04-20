<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Document;
use App\Models\DocumentCategory;
use Illuminate\Database\Seeder;

final class DocumentSeeder extends Seeder
{
    public function run(): void
    {
        $catRut        = DocumentCategory::where('slug', 'registro-dian-rut')->first();
        $catEstatutos  = DocumentCategory::where('slug', 'estatutos')->first();
        $catPersoneria = DocumentCategory::where('slug', 'personeria-juridica')->first();
        $catInformes   = DocumentCategory::where('slug', 'informes-de-gestion')->first();
        $catFinanciero = DocumentCategory::where('slug', 'estados-financieros')->first();
        $catCert       = DocumentCategory::where('slug', 'certificados')->first();

        $documents = [
            ['title' => 'RUT — Registro Único Tributario',     'description' => 'Registro Único Tributario de la Fundación Hogar del Anciano Nazareth ante la DIAN.',                          'document_category_id' => $catRut?->id,        'year' => '2025'],
            ['title' => 'Estatutos de la fundación',           'description' => 'Estatutos vigentes de la Fundación Hogar del Anciano Nazareth, aprobados en asamblea.',                       'document_category_id' => $catEstatutos?->id,  'year' => '2024'],
            ['title' => 'Personería jurídica',                 'description' => 'Certificado de existencia y representación legal expedido por la Gobernación de Risaralda.',                  'document_category_id' => $catPersoneria?->id, 'year' => '2024'],
            ['title' => 'Informe de gestión 2024',             'description' => 'Informe anual de actividades, proyectos, logros y retos de la fundación durante el año 2024.',               'document_category_id' => $catInformes?->id,   'year' => '2024'],
            ['title' => 'Informe de gestión 2023',             'description' => 'Informe anual de actividades, proyectos, logros y retos de la fundación durante el año 2023.',               'document_category_id' => $catInformes?->id,   'year' => '2023'],
            ['title' => 'Estados financieros 2024',            'description' => 'Balance general, estado de resultados y notas contables del ejercicio fiscal 2024.',                          'document_category_id' => $catFinanciero?->id, 'year' => '2024'],
            ['title' => 'Estados financieros 2023',            'description' => 'Balance general, estado de resultados y notas contables del ejercicio fiscal 2023.',                          'document_category_id' => $catFinanciero?->id, 'year' => '2023'],
            ['title' => 'Certificado de no deudor DIAN 2025',  'description' => 'Paz y salvo de obligaciones tributarias ante la DIAN, vigente para el año 2025.',                            'document_category_id' => $catCert?->id,       'year' => '2025'],
            ['title' => 'Certificado de no deudor DIAN 2024',  'description' => 'Paz y salvo de obligaciones tributarias ante la DIAN, vigente para el año 2024.',                            'document_category_id' => $catCert?->id,       'year' => '2024'],
        ];

        foreach ($documents as $data) {
            if ($data['document_category_id']) {
                Document::firstOrCreate(
                    ['title' => $data['title'], 'year' => $data['year']],
                    $data
                );
            }
        }
    }
}
