<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use App\Services\SettingService;
use Illuminate\Contracts\View\View;
use Livewire\Component;

/**
 * Livewire component for the admin site-settings form.
 *
 * Displays all five setting groups (Organización, Contacto, Redes sociales,
 * Correo, Donaciones) on a single page. Never redirects — dispatches a
 * toast notification on save instead.
 */
final class SettingsForm extends Component
{
    // Organización
    public string $orgName     = '';
    public string $orgTagline  = '';
    public string $orgNit      = '';

    // Contacto
    public string $contactEmail    = '';
    public string $contactPhone    = '';
    public string $contactWhatsapp = '';
    public string $contactAddress  = '';
    public string $contactSchedule = '';
    public string $contactMapsUrl  = '';

    // Redes sociales
    public string $socialFacebook  = '';
    public string $socialInstagram = '';
    public string $socialYoutube   = '';
    public string $socialTiktok    = '';
    public string $socialLinkedin  = '';

    // Correo del sistema
    public string $mailContactTo    = '';
    public string $mailFromName     = '';
    public string $mailFromAddress  = '';

    // Donaciones
    public string $donationBankName       = '';
    public string $donationAccountType    = '';
    public string $donationAccount        = '';
    public string $donationAccountHolder  = '';
    public string $donationNitBank        = '';

    private SettingService $settingService;

    public function boot(SettingService $settingService): void
    {
        $this->settingService = $settingService;
    }

    public function mount(): void
    {
        $s = $this->settingService->get();

        $this->orgName    = $s->org_name    ?? '';
        $this->orgTagline = $s->org_tagline ?? '';
        $this->orgNit     = $s->org_nit     ?? '';

        $this->contactEmail    = $s->contact_email    ?? '';
        $this->contactPhone    = $s->contact_phone    ?? '';
        $this->contactWhatsapp = $s->contact_whatsapp ?? '';
        $this->contactAddress  = $s->contact_address  ?? '';
        $this->contactSchedule = $s->contact_schedule ?? '';
        $this->contactMapsUrl  = $s->contact_maps_url ?? '';

        $this->socialFacebook  = $s->social_facebook  ?? '';
        $this->socialInstagram = $s->social_instagram ?? '';
        $this->socialYoutube   = $s->social_youtube   ?? '';
        $this->socialTiktok    = $s->social_tiktok    ?? '';
        $this->socialLinkedin  = $s->social_linkedin  ?? '';

        $this->mailContactTo   = $s->mail_contact_to   ?? '';
        $this->mailFromName    = $s->mail_from_name    ?? '';
        $this->mailFromAddress = $s->mail_from_address ?? '';

        $this->donationBankName      = $s->donation_bank_name      ?? '';
        $this->donationAccountType   = $s->donation_account_type   ?? '';
        $this->donationAccount       = $s->donation_account        ?? '';
        $this->donationAccountHolder = $s->donation_account_holder ?? '';
        $this->donationNitBank       = $s->donation_nit_bank       ?? '';
    }

    /** @return array<string, mixed> */
    protected function rules(): array
    {
        return [
            'orgName'    => ['required', 'string', 'max:255'],
            'orgTagline' => ['nullable', 'string', 'max:255'],
            'orgNit'     => ['nullable', 'string', 'max:50'],

            'contactEmail'    => ['nullable', 'email', 'max:255'],
            'contactPhone'    => ['nullable', 'string', 'max:50'],
            'contactWhatsapp' => ['nullable', 'regex:/^[0-9]*$/', 'max:20'],
            'contactAddress'  => ['nullable', 'string', 'max:255'],
            'contactSchedule' => ['nullable', 'string', 'max:255'],
            'contactMapsUrl'  => ['nullable', 'string', 'max:2000'],

            'socialFacebook'  => ['nullable', 'url', 'max:255'],
            'socialInstagram' => ['nullable', 'url', 'max:255'],
            'socialYoutube'   => ['nullable', 'url', 'max:255'],
            'socialTiktok'    => ['nullable', 'url', 'max:255'],
            'socialLinkedin'  => ['nullable', 'url', 'max:255'],

            'mailContactTo'   => ['nullable', 'email', 'max:255'],
            'mailFromName'    => ['nullable', 'string', 'max:100'],
            'mailFromAddress' => ['nullable', 'email', 'max:255'],

            'donationBankName'      => ['nullable', 'string', 'max:100'],
            'donationAccountType'   => ['nullable', 'string', 'max:100'],
            'donationAccount'       => ['nullable', 'string', 'max:50'],
            'donationAccountHolder' => ['nullable', 'string', 'max:255'],
            'donationNitBank'       => ['nullable', 'string', 'max:50'],
        ];
    }

    /** @return array<string, string> */
    protected function messages(): array
    {
        return [
            'orgName.required'          => 'El nombre de la organización es obligatorio.',
            'contactEmail.email'        => 'El correo de contacto no tiene un formato válido.',
            'contactWhatsapp.regex'     => 'El WhatsApp debe contener solo dígitos (sin espacios ni guiones).',
            'socialFacebook.url'        => 'El enlace de Facebook no es una URL válida.',
            'socialInstagram.url'       => 'El enlace de Instagram no es una URL válida.',
            'socialYoutube.url'         => 'El enlace de YouTube no es una URL válida.',
            'socialTiktok.url'          => 'El enlace de TikTok no es una URL válida.',
            'socialLinkedin.url'        => 'El enlace de LinkedIn no es una URL válida.',
            'mailContactTo.email'       => 'El correo destino no tiene un formato válido.',
            'mailFromAddress.email'     => 'El correo remitente no tiene un formato válido.',
        ];
    }

    public function save(): void
    {
        $this->validate($this->rules(), $this->messages());

        $this->settingService->update([
            'org_name'    => $this->orgName,
            'org_tagline' => $this->orgTagline ?: null,
            'org_nit'     => $this->orgNit ?: null,

            'contact_email'    => $this->contactEmail ?: null,
            'contact_phone'    => $this->contactPhone ?: null,
            'contact_whatsapp' => $this->contactWhatsapp ?: null,
            'contact_address'  => $this->contactAddress ?: null,
            'contact_schedule' => $this->contactSchedule ?: null,
            'contact_maps_url' => $this->contactMapsUrl ?: null,

            'social_facebook'  => $this->socialFacebook ?: null,
            'social_instagram' => $this->socialInstagram ?: null,
            'social_youtube'   => $this->socialYoutube ?: null,
            'social_tiktok'    => $this->socialTiktok ?: null,
            'social_linkedin'  => $this->socialLinkedin ?: null,

            'mail_contact_to'   => $this->mailContactTo ?: null,
            'mail_from_name'    => $this->mailFromName ?: null,
            'mail_from_address' => $this->mailFromAddress ?: null,

            'donation_bank_name'      => $this->donationBankName ?: null,
            'donation_account_type'   => $this->donationAccountType ?: null,
            'donation_account'        => $this->donationAccount ?: null,
            'donation_account_holder' => $this->donationAccountHolder ?: null,
            'donation_nit_bank'       => $this->donationNitBank ?: null,
        ]);

        $this->dispatch('notify', message: 'Configuración guardada correctamente.');
    }

    public function render(): View
    {
        return view('livewire.admin.settings-form');
    }
}
