<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();

            // Organización
            $table->string('org_name')->default('Fundación Hogar del Anciano Nazareth');
            $table->string('org_tagline')->nullable();
            $table->string('org_nit')->nullable();

            // Contacto
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('contact_whatsapp')->nullable();    // solo dígitos, para wa.me/
            $table->string('contact_address')->nullable();
            $table->string('contact_schedule')->nullable();    // "Lun–Vie 8am–5pm"
            $table->text('contact_maps_url')->nullable();      // iframe src de Google Maps

            // Redes sociales
            $table->string('social_facebook')->nullable();
            $table->string('social_instagram')->nullable();
            $table->string('social_youtube')->nullable();
            $table->string('social_tiktok')->nullable();
            $table->string('social_linkedin')->nullable();

            // Correo del sistema (interno, no público)
            $table->string('mail_contact_to')->nullable();     // destino del formulario de contacto
            $table->string('mail_from_name')->nullable();
            $table->string('mail_from_address')->nullable();

            // Donaciones
            $table->string('donation_bank_name')->nullable();
            $table->string('donation_account_type')->nullable(); // "Cuenta de ahorros"
            $table->string('donation_account')->nullable();
            $table->string('donation_account_holder')->nullable();
            $table->string('donation_nit_bank')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
