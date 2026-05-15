<div>
    <div class="mb-6">
        <h2 class="text-xl font-medium text-gray-900">Configuración del sitio</h2>
        <p class="mt-1 text-sm text-gray-500">
            Datos institucionales, contacto, redes sociales, correo y donaciones.
        </p>
    </div>

    <div class="space-y-6">

        {{-- ── 1. Organización ──────────────────────────────────────── --}}
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            <h3 class="mb-4 text-sm font-semibold uppercase tracking-wide text-gray-500">Organización</h3>

            <div class="space-y-4">
                {{-- Nombre --}}
                <div>
                    <label for="orgName" class="block text-sm font-medium text-gray-700">
                        Nombre de la organización <span class="text-red-500">*</span>
                    </label>
                    <input
                        id="orgName"
                        type="text"
                        wire:model="orgName"
                        class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 shadow-sm
                               focus:border-nazareth-blue focus:outline-none focus:ring-2 focus:ring-nazareth-blue/20
                               @error('orgName') border-red-400 focus:border-red-400 focus:ring-red-200 @enderror"
                    >
                    @error('orgName')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tagline --}}
                <div>
                    <label for="orgTagline" class="block text-sm font-medium text-gray-700">Lema / Eslogan</label>
                    <input
                        id="orgTagline"
                        type="text"
                        wire:model="orgTagline"
                        placeholder="Ej. Cuidando con amor a nuestros adultos mayores"
                        class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 shadow-sm
                               focus:border-nazareth-blue focus:outline-none focus:ring-2 focus:ring-nazareth-blue/20"
                    >
                </div>

                {{-- NIT --}}
                <div>
                    <label for="orgNit" class="block text-sm font-medium text-gray-700">NIT</label>
                    <input
                        id="orgNit"
                        type="text"
                        wire:model="orgNit"
                        placeholder="Ej. 900.123.456-7"
                        class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 shadow-sm
                               focus:border-nazareth-blue focus:outline-none focus:ring-2 focus:ring-nazareth-blue/20"
                    >
                </div>
            </div>
        </div>

        {{-- ── 2. Información de Contacto ───────────────────────────── --}}
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            <h3 class="mb-4 text-sm font-semibold uppercase tracking-wide text-gray-500">Información de Contacto</h3>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                {{-- Correo público --}}
                <div>
                    <label for="contactEmail" class="block text-sm font-medium text-gray-700">Correo electrónico</label>
                    <input
                        id="contactEmail"
                        type="email"
                        wire:model="contactEmail"
                        placeholder="contacto@hogar.org"
                        class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 shadow-sm
                               focus:border-nazareth-blue focus:outline-none focus:ring-2 focus:ring-nazareth-blue/20
                               @error('contactEmail') border-red-400 @enderror"
                    >
                    @error('contactEmail')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Teléfono --}}
                <div>
                    <label for="contactPhone" class="block text-sm font-medium text-gray-700">Teléfono</label>
                    <input
                        id="contactPhone"
                        type="text"
                        wire:model="contactPhone"
                        placeholder="Ej. (604) 234 5678"
                        class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 shadow-sm
                               focus:border-nazareth-blue focus:outline-none focus:ring-2 focus:ring-nazareth-blue/20"
                    >
                </div>

                {{-- WhatsApp --}}
                <div>
                    <label for="contactWhatsapp" class="block text-sm font-medium text-gray-700">WhatsApp</label>
                    <input
                        id="contactWhatsapp"
                        type="text"
                        wire:model="contactWhatsapp"
                        placeholder="3001234567"
                        class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 shadow-sm
                               focus:border-nazareth-blue focus:outline-none focus:ring-2 focus:ring-nazareth-blue/20
                               @error('contactWhatsapp') border-red-400 @enderror"
                    >
                    <p class="mt-1 text-xs text-gray-400">Solo dígitos, sin espacios ni guiones. Ej: 3001234567</p>
                    @error('contactWhatsapp')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Horario --}}
                <div>
                    <label for="contactSchedule" class="block text-sm font-medium text-gray-700">Horario de atención</label>
                    <input
                        id="contactSchedule"
                        type="text"
                        wire:model="contactSchedule"
                        placeholder="Lunes a viernes, 8:00 am – 5:00 pm"
                        class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 shadow-sm
                               focus:border-nazareth-blue focus:outline-none focus:ring-2 focus:ring-nazareth-blue/20"
                    >
                </div>

                {{-- Dirección (ancho completo) --}}
                <div class="sm:col-span-2">
                    <label for="contactAddress" class="block text-sm font-medium text-gray-700">Dirección</label>
                    <input
                        id="contactAddress"
                        type="text"
                        wire:model="contactAddress"
                        placeholder="Calle 1 # 2-3, Municipio, Departamento"
                        class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 shadow-sm
                               focus:border-nazareth-blue focus:outline-none focus:ring-2 focus:ring-nazareth-blue/20"
                    >
                </div>

                {{-- URL Mapa (ancho completo) --}}
                <div class="sm:col-span-2">
                    <label for="contactMapsUrl" class="block text-sm font-medium text-gray-700">Mapa de Google (URL)</label>
                    <textarea
                        id="contactMapsUrl"
                        wire:model="contactMapsUrl"
                        rows="3"
                        placeholder="Pega aquí el valor del atributo src del iframe de Google Maps"
                        class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 shadow-sm
                               focus:border-nazareth-blue focus:outline-none focus:ring-2 focus:ring-nazareth-blue/20
                               @error('contactMapsUrl') border-red-400 @enderror"
                    ></textarea>
                    <p class="mt-1 text-xs text-gray-400">
                        En Google Maps: Compartir → Insertar un mapa → copia solo el valor de <code>src="..."</code>
                    </p>
                    @error('contactMapsUrl')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- ── 3. Redes Sociales ────────────────────────────────────── --}}
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            <h3 class="mb-4 text-sm font-semibold uppercase tracking-wide text-gray-500">Redes Sociales</h3>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <label for="socialFacebook" class="block text-sm font-medium text-gray-700">Facebook</label>
                    <input
                        id="socialFacebook"
                        type="url"
                        wire:model="socialFacebook"
                        placeholder="https://facebook.com/..."
                        class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 shadow-sm
                               focus:border-nazareth-blue focus:outline-none focus:ring-2 focus:ring-nazareth-blue/20
                               @error('socialFacebook') border-red-400 @enderror"
                    >
                    @error('socialFacebook')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="socialInstagram" class="block text-sm font-medium text-gray-700">Instagram</label>
                    <input
                        id="socialInstagram"
                        type="url"
                        wire:model="socialInstagram"
                        placeholder="https://instagram.com/..."
                        class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 shadow-sm
                               focus:border-nazareth-blue focus:outline-none focus:ring-2 focus:ring-nazareth-blue/20
                               @error('socialInstagram') border-red-400 @enderror"
                    >
                    @error('socialInstagram')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="socialYoutube" class="block text-sm font-medium text-gray-700">YouTube</label>
                    <input
                        id="socialYoutube"
                        type="url"
                        wire:model="socialYoutube"
                        placeholder="https://youtube.com/@..."
                        class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 shadow-sm
                               focus:border-nazareth-blue focus:outline-none focus:ring-2 focus:ring-nazareth-blue/20
                               @error('socialYoutube') border-red-400 @enderror"
                    >
                    @error('socialYoutube')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="socialTiktok" class="block text-sm font-medium text-gray-700">TikTok</label>
                    <input
                        id="socialTiktok"
                        type="url"
                        wire:model="socialTiktok"
                        placeholder="https://tiktok.com/@..."
                        class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 shadow-sm
                               focus:border-nazareth-blue focus:outline-none focus:ring-2 focus:ring-nazareth-blue/20
                               @error('socialTiktok') border-red-400 @enderror"
                    >
                    @error('socialTiktok')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:col-span-2">
                    <label for="socialLinkedin" class="block text-sm font-medium text-gray-700">LinkedIn</label>
                    <input
                        id="socialLinkedin"
                        type="url"
                        wire:model="socialLinkedin"
                        placeholder="https://linkedin.com/company/..."
                        class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 shadow-sm
                               focus:border-nazareth-blue focus:outline-none focus:ring-2 focus:ring-nazareth-blue/20
                               @error('socialLinkedin') border-red-400 @enderror"
                    >
                    @error('socialLinkedin')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- ── 4. Configuración de Correo ───────────────────────────── --}}
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            <h3 class="mb-4 text-sm font-semibold uppercase tracking-wide text-gray-500">Configuración de Correo</h3>
            <p class="mb-4 text-xs text-gray-400">
                Datos internos para el envío de formularios. No se muestran en el sitio público.
            </p>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                {{-- Destino --}}
                <div class="sm:col-span-2">
                    <label for="mailContactTo" class="block text-sm font-medium text-gray-700">Correo de destino</label>
                    <input
                        id="mailContactTo"
                        type="email"
                        wire:model="mailContactTo"
                        placeholder="admin@hogar.org"
                        class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 shadow-sm
                               focus:border-nazareth-blue focus:outline-none focus:ring-2 focus:ring-nazareth-blue/20
                               @error('mailContactTo') border-red-400 @enderror"
                    >
                    <p class="mt-1 text-xs text-gray-400">Recibirá los mensajes del formulario de contacto del sitio web.</p>
                    @error('mailContactTo')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Nombre remitente --}}
                <div>
                    <label for="mailFromName" class="block text-sm font-medium text-gray-700">Nombre del remitente</label>
                    <input
                        id="mailFromName"
                        type="text"
                        wire:model="mailFromName"
                        placeholder="Fundación Centro de Bienestar del Anciano Nazareth"
                        class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 shadow-sm
                               focus:border-nazareth-blue focus:outline-none focus:ring-2 focus:ring-nazareth-blue/20"
                    >
                </div>

                {{-- Correo remitente --}}
                <div>
                    <label for="mailFromAddress" class="block text-sm font-medium text-gray-700">Correo remitente</label>
                    <input
                        id="mailFromAddress"
                        type="email"
                        wire:model="mailFromAddress"
                        placeholder="noreply@hogar.org"
                        class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 shadow-sm
                               focus:border-nazareth-blue focus:outline-none focus:ring-2 focus:ring-nazareth-blue/20
                               @error('mailFromAddress') border-red-400 @enderror"
                    >
                    @error('mailFromAddress')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- ── 5. Donaciones ────────────────────────────────────────── --}}
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            <h3 class="mb-1 text-sm font-semibold uppercase tracking-wide text-gray-500">Donaciones</h3>
            <p class="mb-5 text-xs text-gray-400">
                Información para que los visitantes puedan realizar donaciones por distintos medios.
            </p>

            {{-- Cuenta bancaria --}}
            <p class="mb-3 text-xs font-semibold uppercase tracking-wide text-gray-400">Transferencia bancaria</p>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <label for="donationBankName" class="block text-sm font-medium text-gray-700">Banco</label>
                    <input
                        id="donationBankName"
                        type="text"
                        wire:model="donationBankName"
                        placeholder="Bancolombia"
                        class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 shadow-sm
                               focus:border-nazareth-blue focus:outline-none focus:ring-2 focus:ring-nazareth-blue/20"
                    >
                </div>

                <div>
                    <label for="donationAccountType" class="block text-sm font-medium text-gray-700">Tipo de cuenta</label>
                    <input
                        id="donationAccountType"
                        type="text"
                        wire:model="donationAccountType"
                        placeholder="Cuenta de ahorros"
                        class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 shadow-sm
                               focus:border-nazareth-blue focus:outline-none focus:ring-2 focus:ring-nazareth-blue/20"
                    >
                </div>

                <div>
                    <label for="donationAccount" class="block text-sm font-medium text-gray-700">Número de cuenta</label>
                    <input
                        id="donationAccount"
                        type="text"
                        wire:model="donationAccount"
                        placeholder="123-456789-00"
                        class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 shadow-sm
                               focus:border-nazareth-blue focus:outline-none focus:ring-2 focus:ring-nazareth-blue/20"
                    >
                </div>

                <div>
                    <label for="donationNitBank" class="block text-sm font-medium text-gray-700">NIT del titular de la cuenta</label>
                    <input
                        id="donationNitBank"
                        type="text"
                        wire:model="donationNitBank"
                        placeholder="900.123.456-7"
                        class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 shadow-sm
                               focus:border-nazareth-blue focus:outline-none focus:ring-2 focus:ring-nazareth-blue/20"
                    >
                </div>

                <div class="sm:col-span-2">
                    <label for="donationAccountHolder" class="block text-sm font-medium text-gray-700">Titular de la cuenta</label>
                    <input
                        id="donationAccountHolder"
                        type="text"
                        wire:model="donationAccountHolder"
                        placeholder="Fundación Centro de Bienestar del Anciano Nazareth"
                        class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 shadow-sm
                               focus:border-nazareth-blue focus:outline-none focus:ring-2 focus:ring-nazareth-blue/20"
                    >
                </div>
            </div>

            {{-- Pagos digitales --}}
            <p class="mb-3 mt-6 text-xs font-semibold uppercase tracking-wide text-gray-400">Pagos digitales</p>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <label for="donationNequi" class="block text-sm font-medium text-gray-700">Número de Nequi</label>
                    <input
                        id="donationNequi"
                        type="text"
                        wire:model="donationNequi"
                        placeholder="3001234567"
                        maxlength="10"
                        class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 shadow-sm
                               focus:border-nazareth-blue focus:outline-none focus:ring-2 focus:ring-nazareth-blue/20
                               @error('donationNequi') border-red-400 @enderror"
                    >
                    @error('donationNequi')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="donationDaviplata" class="block text-sm font-medium text-gray-700">Número de Daviplata</label>
                    <input
                        id="donationDaviplata"
                        type="text"
                        wire:model="donationDaviplata"
                        placeholder="3101234567"
                        maxlength="10"
                        class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 shadow-sm
                               focus:border-nazareth-blue focus:outline-none focus:ring-2 focus:ring-nazareth-blue/20
                               @error('donationDaviplata') border-red-400 @enderror"
                    >
                    @error('donationDaviplata')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-4">
                <label for="donationBreb" class="block text-sm font-medium text-gray-700">Llave Bre-B</label>
                <p class="mt-0.5 text-xs text-gray-400">Puede ser un número de celular, correo electrónico, número de cuenta o NIT registrado en Bre-B.</p>
                <input
                    id="donationBreb"
                    type="text"
                    wire:model="donationBreb"
                    placeholder="Ej: 3001234567 o correo@ejemplo.com"
                    maxlength="100"
                    class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 shadow-sm
                           focus:border-nazareth-blue focus:outline-none focus:ring-2 focus:ring-nazareth-blue/20
                           @error('donationBreb') border-red-400 @enderror"
                >
                @error('donationBreb')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Código QR --}}
            <p class="mb-3 mt-6 text-xs font-semibold uppercase tracking-wide text-gray-400">Código QR de donación</p>
            <p class="mb-3 text-xs text-gray-400">
                Sube la imagen del QR de la cuenta bancaria o billetera digital. Se mostrará en la página de donaciones para que los visitantes puedan escanearla directamente desde su celular.
            </p>

            @if($donationQrMediaId && $qrMedia)
                <div class="flex items-start gap-4">
                    <img
                        src="{{ Storage::url($qrMedia->file_path) }}"
                        alt="Código QR de donación"
                        class="h-32 w-32 rounded-lg border border-gray-200 object-contain p-1 shadow-sm"
                    >
                    <div class="flex flex-col gap-2">
                        <p class="text-sm text-gray-600">QR guardado correctamente.</p>
                        <button
                            type="button"
                            wire:click="removeQr"
                            wire:confirm="¿Eliminar el código QR de donación?"
                            class="inline-flex w-fit items-center gap-1.5 rounded-lg border border-red-200 bg-red-50 px-3 py-1.5 text-sm font-medium text-red-600 transition-colors hover:bg-red-100"
                        >
                            Eliminar QR
                        </button>
                    </div>
                </div>
            @else
                <div
                    class="relative rounded-lg border-2 border-dashed border-gray-300 p-6 text-center transition-colors hover:border-nazareth-blue/50
                           @error('donationQrUpload') border-red-400 @enderror"
                >
                    <svg class="mx-auto mb-2 h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <label for="donationQrUpload" class="cursor-pointer text-sm font-medium text-nazareth-blue hover:underline">
                        Seleccionar imagen del QR
                    </label>
                    <input
                        id="donationQrUpload"
                        type="file"
                        wire:model="donationQrUpload"
                        accept="image/jpeg,image/png,image/webp"
                        class="sr-only"
                    >
                    <p class="mt-1 text-xs text-gray-400">JPG, PNG o WebP · Máx. 2 MB</p>

                    <div wire:loading wire:target="donationQrUpload" class="mt-2 text-xs text-nazareth-blue">
                        Subiendo imagen...
                    </div>
                </div>

                @if($donationQrUpload)
                    <div class="mt-3 flex items-center gap-3 rounded-lg bg-green-50 px-4 py-2.5">
                        <svg class="h-4 w-4 shrink-0 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <p class="text-sm text-green-700">Imagen lista para guardar: <strong>{{ $donationQrUpload->getClientOriginalName() }}</strong></p>
                    </div>
                @endif

                @error('donationQrUpload')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            @endif
        </div>

        {{-- ── Guardar ───────────────────────────────────────────────── --}}
        <div class="flex justify-end border-t border-gray-200 pt-6">
            <button
                wire:click="save"
                wire:loading.attr="disabled"
                wire:target="save"
                class="inline-flex items-center justify-center rounded-lg bg-nazareth-blue px-5 py-2.5 text-sm font-medium text-white shadow-sm
                       transition-colors hover:bg-nazareth-light focus:outline-none focus:ring-2 focus:ring-nazareth-blue focus:ring-offset-2 disabled:opacity-60"
            >
                <span wire:loading.remove wire:target="save">Guardar configuración</span>
                <span wire:loading wire:target="save">Guardando...</span>
            </button>
        </div>

    </div>
</div>
