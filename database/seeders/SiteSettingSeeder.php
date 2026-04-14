<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        SiteSetting::updateOrCreate(['id' => 1], [
            'org_name'         => 'Fundación Hogar del Anciano Nazareth',
            'org_tagline'      => 'Cuidando con amor a nuestros adultos mayores',
            'social_facebook'  => 'https://web.facebook.com/hogardelanciano.nazareth',
            'contact_schedule' => 'Lunes a viernes, 8:00 am – 5:00 pm',
            'mail_from_name'   => 'Hogar Nazareth',
        ]);
    }
}
