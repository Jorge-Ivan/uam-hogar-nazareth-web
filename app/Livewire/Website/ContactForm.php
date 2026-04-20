<?php

declare(strict_types=1);

namespace App\Livewire\Website;

use App\Jobs\SendContactEmail;
use App\Services\ReCaptchaService;
use App\Services\SettingService;
use Livewire\Component;

final class ContactForm extends Component
{
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $subject = '';
    public string $message = '';
    public string $honeypot = '';
    public bool $sent = false;
    public string $recaptchaToken = '';

    protected function rules(): array
    {
        return [
            'name'    => ['required', 'string', 'max:100'],
            'email'   => ['required', 'email', 'max:150'],
            'phone'   => ['nullable', 'string', 'max:20'],
            'subject' => ['required', 'string', 'max:100'],
            'message' => ['required', 'string', 'min:10', 'max:2000'],
        ];
    }

    protected function messages(): array
    {
        return [
            'name.required'    => 'El nombre es obligatorio.',
            'name.max'         => 'El nombre no puede superar los 100 caracteres.',
            'email.required'   => 'El correo electrónico es obligatorio.',
            'email.email'      => 'Ingresa un correo electrónico válido.',
            'subject.required' => 'Selecciona el motivo de contacto.',
            'message.required' => 'El mensaje es obligatorio.',
            'message.min'      => 'El mensaje debe tener al menos 10 caracteres.',
            'message.max'      => 'El mensaje no puede superar los 2000 caracteres.',
        ];
    }

    public function submit(SettingService $settingService, ReCaptchaService $recaptcha): void
    {
        if ($this->honeypot !== '') {
            $this->reset(['name', 'email', 'phone', 'message', 'honeypot']);
            return;
        }

        if (! $recaptcha->verify($this->recaptchaToken)) {
            $this->addError('form', 'No se pudo verificar que eres humano. Intenta de nuevo.');
            return;
        }

        $this->validate();

        $settings = $settingService->get();

        if (empty($settings->mail_contact_to)) {
            $this->addError('form', 'El formulario de contacto no está disponible en este momento.');
            return;
        }

        SendContactEmail::dispatch(
            formData: [
                'name'    => $this->name,
                'email'   => $this->email,
                'phone'   => $this->phone ?: null,
                'subject' => $this->subject,
                'message' => $this->message,
            ],
            mailTo: $settings->mail_contact_to,
            fromName: $settings->mail_from_name ?? $settings->org_name,
            fromAddress: $settings->mail_from_address ?? $settings->mail_contact_to,
        );

        $this->sent = true;
        $this->reset(['name', 'email', 'phone', 'subject', 'message', 'honeypot', 'recaptchaToken']);
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.website.contact-form');
    }
}
