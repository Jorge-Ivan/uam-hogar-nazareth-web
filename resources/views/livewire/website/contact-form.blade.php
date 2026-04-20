<div>
    {{-- ── Estado enviado ── --}}
    @if($sent)
    <div class="bg-nazareth-green/10 border border-nazareth-green rounded-[14px] p-8 text-center">
        <svg class="w-12 h-12 text-nazareth-green mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <h3 class="font-semibold text-nazareth-green text-lg mb-1">¡Mensaje enviado!</h3>
        <p class="text-[#4B5A5E] text-[15px]">Gracias por contactarnos. Te respondemos en menos de 24 horas hábiles.</p>
        <button wire:click="$set('sent', false)"
                class="mt-4 text-sm text-nazareth-blue hover:underline focus:outline-none focus:ring-2 focus:ring-nazareth-gold rounded">
            Enviar otro mensaje
        </button>
    </div>
    @else
    <form
        x-data
        x-on:submit.prevent="
            grecaptcha.ready(function() {
                grecaptcha.execute('{{ config('services.recaptcha.site_key') }}', {action: 'contact'}).then(function(token) {
                    $wire.set('recaptchaToken', token);
                    $wire.submit();
                });
            });
        "
        novalidate>

        {{-- Error general --}}
        @error('form')
        <div class="bg-red-50 border border-red-200 rounded-[10px] p-3 mb-5">
            <p class="text-sm text-red-700">{{ $message }}</p>
        </div>
        @enderror

        {{-- reCAPTCHA token --}}
        <input type="hidden" wire:model="recaptchaToken">

        {{-- Honeypot --}}
        <div class="hidden" aria-hidden="true">
            <label for="website_url">No rellenar</label>
            <input type="text" id="website_url" wire:model="honeypot" autocomplete="off" tabindex="-1">
        </div>

        {{-- Nombre + Teléfono --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5">
            <div>
                <label for="cf-name" class="block text-[14px] font-medium text-nazareth-ink mb-1.5">
                    Nombre <span class="text-red-500" aria-hidden="true">*</span>
                </label>
                <input type="text"
                       id="cf-name"
                       wire:model="name"
                       autocomplete="name"
                       placeholder="Tu nombre completo"
                       required
                       aria-required="true"
                       class="w-full px-3.5 py-2.5 text-[15px] border rounded-[10px] text-nazareth-ink placeholder-[#9CA3AF] focus:outline-none focus:border-nazareth-light focus:ring-[3px] focus:ring-nazareth-light/15 transition
                           {{ $errors->has('name') ? 'border-red-400 bg-red-50' : 'border-[#E3EAEB]' }}">
                @error('name')
                <p class="mt-1 text-[13px] text-red-600" role="alert">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="cf-phone" class="block text-[14px] font-medium text-nazareth-ink mb-1.5">
                    Teléfono <span class="text-[#9CA3AF] text-[12px]">(opcional)</span>
                </label>
                <input type="tel"
                       id="cf-phone"
                       wire:model="phone"
                       autocomplete="tel"
                       placeholder="+57 300 000 0000"
                       class="w-full px-3.5 py-2.5 text-[15px] border border-[#E3EAEB] rounded-[10px] text-nazareth-ink placeholder-[#9CA3AF] focus:outline-none focus:border-nazareth-light focus:ring-[3px] focus:ring-nazareth-light/15 transition">
            </div>
        </div>

        {{-- Correo --}}
        <div class="mb-5">
            <label for="cf-email" class="block text-[14px] font-medium text-nazareth-ink mb-1.5">
                Correo electrónico <span class="text-red-500" aria-hidden="true">*</span>
            </label>
            <input type="email"
                   id="cf-email"
                   wire:model="email"
                   autocomplete="email"
                   placeholder="tunombre@correo.com"
                   required
                   aria-required="true"
                   class="w-full px-3.5 py-2.5 text-[15px] border rounded-[10px] text-nazareth-ink placeholder-[#9CA3AF] focus:outline-none focus:border-nazareth-light focus:ring-[3px] focus:ring-nazareth-light/15 transition
                       {{ $errors->has('email') ? 'border-red-400 bg-red-50' : 'border-[#E3EAEB]' }}">
            @error('email')
            <p class="mt-1 text-[13px] text-red-600" role="alert">{{ $message }}</p>
            @enderror
        </div>

        {{-- Motivo --}}
        <div class="mb-5">
            <label for="cf-subject" class="block text-[14px] font-medium text-nazareth-ink mb-1.5">
                Motivo de contacto <span class="text-red-500" aria-hidden="true">*</span>
            </label>
            <select id="cf-subject"
                    wire:model="subject"
                    required
                    aria-required="true"
                    class="w-full px-3.5 py-2.5 text-[15px] border rounded-[10px] text-nazareth-ink focus:outline-none focus:border-nazareth-light focus:ring-[3px] focus:ring-nazareth-light/15 transition
                        {{ $errors->has('subject') ? 'border-red-400 bg-red-50' : 'border-[#E3EAEB]' }}">
                <option value="">Selecciona una opción...</option>
                <option value="Información sobre donaciones">Información sobre donaciones</option>
                <option value="Quiero ser voluntario">Quiero ser voluntario</option>
                <option value="Ingreso de un familiar">Ingreso de un familiar</option>
                <option value="Apadrinamiento">Apadrinamiento</option>
                <option value="Visitar el hogar">Visitar el hogar</option>
                <option value="Prensa o entrevistas">Prensa o entrevistas</option>
                <option value="Otro">Otro</option>
            </select>
            @error('subject')
            <p class="mt-1 text-[13px] text-red-600" role="alert">{{ $message }}</p>
            @enderror
        </div>

        {{-- Mensaje --}}
        <div class="mb-5">
            <label for="cf-message" class="block text-[14px] font-medium text-nazareth-ink mb-1.5">
                Mensaje <span class="text-red-500" aria-hidden="true">*</span>
            </label>
            <textarea id="cf-message"
                      wire:model="message"
                      rows="5"
                      placeholder="Cuéntanos un poco sobre lo que necesitas..."
                      required
                      aria-required="true"
                      class="w-full px-3.5 py-2.5 text-[15px] border rounded-[10px] text-nazareth-ink placeholder-[#9CA3AF] focus:outline-none focus:border-nazareth-light focus:ring-[3px] focus:ring-nazareth-light/15 transition resize-y
                          {{ $errors->has('message') ? 'border-red-400 bg-red-50' : 'border-[#E3EAEB]' }}"></textarea>
            @error('message')
            <p class="mt-1 text-[13px] text-red-600" role="alert">{{ $message }}</p>
            @enderror
        </div>

        {{-- Política de datos --}}
        <label class="flex items-start gap-2.5 mb-6 cursor-pointer">
            <input type="checkbox"
                   required
                   class="mt-[3px] rounded border-[#E3EAEB] text-nazareth-blue focus:ring-nazareth-light shrink-0">
            <span class="text-[13px] text-[#4B5A5E]">He leído y acepto la política de tratamiento de datos personales.</span>
        </label>

        {{-- Enviar --}}
        <button type="submit"
                wire:loading.attr="disabled"
                class="w-full py-3.5 px-[22px] bg-nazareth-gold text-white text-[15px] font-semibold rounded-[10px] hover:bg-amber-600 transition-colors focus:outline-none focus:ring-2 focus:ring-nazareth-gold focus:ring-offset-2 disabled:opacity-60">
            <span wire:loading.remove>Enviar mensaje</span>
            <span wire:loading class="flex items-center justify-center gap-2">
                <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 22 6.477 22 12h-4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/>
                </svg>
                Enviando...
            </span>
        </button>
    </form>
    @endif
</div>

@once
<script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}" defer></script>
@endonce
