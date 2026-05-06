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
            'org_name'                => 'Fundación Centro de Bienestar del Anciano Nazareth',
            'org_tagline'             => 'Cuidando con amor a nuestros adultos mayores',
            'org_nit'                 => '891.401.123-4',
            'contact_address'         => 'Calle 8 # 12-45, La Virginia, Risaralda, Colombia',
            'contact_phone'           => '+57 6 2567890',
            'contact_whatsapp'        => '573156789012',
            'contact_email'           => 'contacto@hogarnazareth.org',
            'contact_schedule'        => 'Lunes a sábado, 8:00 am – 5:00 pm',
            'contact_maps_url'        => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3976.123456789!2d-75.8795!3d4.9012!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2sLa+Virginia+Risaralda!5e0!3m2!1ses!2sco!4v1234567890',
            'social_facebook'         => 'https://web.facebook.com/hogardelanciano.nazareth',
            'social_instagram'        => 'https://www.instagram.com/hogarnazareth',
            'social_youtube'          => null,
            'mail_contact_to'         => 'admin@hogarnazareth.com',
            'mail_from_name'          => 'Fundación Centro de Bienestar del Anciano Nazareth',
            'mail_from_address'       => 'contacto@hogarnazareth.org',
            'donation_bank_name'      => 'Bancolombia',
            'donation_account_type'   => 'Cuenta de Ahorros',
            'donation_account'        => '123-456789-12',
            'donation_account_holder' => 'Fundación Centro de Bienestar del Anciano Nazareth',
            'donation_nit_bank'       => '891.401.123-4',
            'donation_nequi'          => '3156789012',
            'donation_daviplata'      => '3156789012',
        ]);
    }
}
