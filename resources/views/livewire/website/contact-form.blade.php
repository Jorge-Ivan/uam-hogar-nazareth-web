<div>
    {{-- Success state --}}
    @if($sent)
    <div class="bg-nazareth-green/10 border border-nazareth-green rounded-xl p-6 text-center">
        <svg class="w-12 h-12 text-nazareth-green mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <h3 class="font-medium text-nazareth-green text-lg">¡Mensaje enviado!</h3>
        <p class="text-gray-600 mt-1">Gracias por contactarnos. Te responderemos pronto.</p>
        <button wire:click="$set('sent', false)" class="mt-4 text-sm text-nazareth-blue hover:underline focus:outline-none focus:ring-2 focus:ring-nazareth-gold rounded">
            Enviar otro mensaje
        </button>
    </div>
    @else
    <form wire:submit="submit" novalidate>
        {{-- Form-level error --}}
        @error('form')
        <div class="bg-red-50 border border-red-200 rounded-lg p-3 mb-4">
            <p class="text-sm text-red-700">{{ $message }}</p>
        </div>
        @enderror

        {{-- Honeypot (hidden from real users) --}}
        <div class="hidden" aria-hidden="true">
            <label for="website_url">No rellenar</label>
            <input type="text" id="website_url" wire:model="honeypot" autocomplete="off" tabindex="-1">
        </div>

        {{-- Name --}}
        <div class="mb-4">
            <label for="contact-name" class="block text-sm font-medium text-gray-700 mb-1">
                Nombre completo <span class="text-red-500" aria-hidden="true">*</span>
            </label>
            <input
                type="text"
                id="contact-name"
                wire:model="name"
                autocomplete="name"
                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-nazareth-blue focus:ring-nazareth-blue @error('name') border-red-400 bg-red-50 @enderror"
                placeholder="Tu nombre"
                required
                aria-required="true"
                aria-describedby="{{ $errors->has('name') ? 'contact-name-error' : '' }}"
            >
            @error('name')
            <p id="contact-name-error" class="mt-1 text-sm text-red-600" role="alert">{{ $message }}</p>
            @enderror
        </div>

        {{-- Email --}}
        <div class="mb-4">
            <label for="contact-email" class="block text-sm font-medium text-gray-700 mb-1">
                Correo electrónico <span class="text-red-500" aria-hidden="true">*</span>
            </label>
            <input
                type="email"
                id="contact-email"
                wire:model="email"
                autocomplete="email"
                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-nazareth-blue focus:ring-nazareth-blue @error('email') border-red-400 bg-red-50 @enderror"
                placeholder="tu@correo.com"
                required
                aria-required="true"
                aria-describedby="{{ $errors->has('email') ? 'contact-email-error' : '' }}"
            >
            @error('email')
            <p id="contact-email-error" class="mt-1 text-sm text-red-600" role="alert">{{ $message }}</p>
            @enderror
        </div>

        {{-- Phone (optional) --}}
        <div class="mb-4">
            <label for="contact-phone" class="block text-sm font-medium text-gray-700 mb-1">
                Teléfono <span class="text-gray-400 text-xs">(opcional)</span>
            </label>
            <input
                type="tel"
                id="contact-phone"
                wire:model="phone"
                autocomplete="tel"
                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-nazareth-blue focus:ring-nazareth-blue"
                placeholder="+57 300 000 0000"
            >
        </div>

        {{-- Message --}}
        <div class="mb-6">
            <label for="contact-message" class="block text-sm font-medium text-gray-700 mb-1">
                Mensaje <span class="text-red-500" aria-hidden="true">*</span>
            </label>
            <textarea
                id="contact-message"
                wire:model="message"
                rows="5"
                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-nazareth-blue focus:ring-nazareth-blue @error('message') border-red-400 bg-red-50 @enderror"
                placeholder="¿En qué podemos ayudarte?"
                required
                aria-required="true"
                aria-describedby="{{ $errors->has('message') ? 'contact-message-error' : '' }}"
            ></textarea>
            @error('message')
            <p id="contact-message-error" class="mt-1 text-sm text-red-600" role="alert">{{ $message }}</p>
            @enderror
        </div>

        {{-- Submit --}}
        <button
            type="submit"
            wire:loading.attr="disabled"
            class="w-full bg-nazareth-blue text-white font-medium py-3 px-6 rounded-lg hover:bg-nazareth-light transition-colors focus:outline-none focus:ring-2 focus:ring-nazareth-gold focus:ring-offset-2 disabled:opacity-60"
        >
            <span wire:loading.remove>Enviar mensaje</span>
            <span wire:loading class="flex items-center justify-center gap-2">
                <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 22 6.477 22 12h-4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Enviando...
            </span>
        </button>
    </form>
    @endif
</div>
