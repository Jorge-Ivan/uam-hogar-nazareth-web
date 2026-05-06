@extends('layouts.public')

@section('meta_title', 'Cómo donar')
@section('meta_description', 'Apoya a la Fundación Hogar del Anciano Nazareth. Aquí están todos los datos para hacer tu aporte directo por transferencia bancaria, Nequi o Daviplata.')

@section('og_title', 'Apoya al Hogar Nazareth — Tu donación cuida a un adulto mayor')
@section('og_description', 'Cualquier aporte se convierte en comida, cuidado y compañía para nuestros adultos mayores. Así de directo puedes ayudar.')
@section('og_image', asset('images/logo_fundacion.png'))
@section('og_image_width', '1920')
@section('og_image_height', '819')
@section('og_image_alt', 'Fundación Hogar del Anciano Nazareth — Apoya nuestra misión')

@push('schema')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebPage",
  "@id": "{{ url()->current() }}#webpage",
  "url": "{{ url()->current() }}",
  "name": "Cómo donar · Hogar Nazareth",
  "description": "Datos de donación directa para apoyar a la Fundación Hogar del Anciano Nazareth por transferencia bancaria, Nequi o Daviplata.",
  "isPartOf": { "@id": "{{ url('/') }}/#website" },
  "inLanguage": "es-CO",
  "potentialAction": {
    "@type": "DonateAction",
    "name": "Donar a la Fundación Hogar del Anciano Nazareth",
    "target": "{{ route('website.donations') }}",
    "recipient": { "@id": "{{ url('/') }}/#organization" }
  }
}
</script>
@endpush


@section('content')

@php
  $hasBankInfo     = $siteSettings->donation_bank_name || $siteSettings->donation_account;
  $hasNequi        = (bool) $siteSettings->donation_nequi;
  $hasDaviplata    = (bool) $siteSettings->donation_daviplata;
  $hasQr           = $siteSettings->donationQr !== null;
  $hasAnyDonation  = $hasBankInfo || $hasNequi || $hasDaviplata;
@endphp

{{-- HERO --}}
<section class="don-hero" aria-labelledby="don-title">
  <div class="don-container">
    <span class="don-eyebrow gold">Apoyar al hogar</span>
    <h1 id="don-title" class="don-h1" style="color:#fff;font-size:clamp(38px,5vw,56px);line-height:1.05;max-width:22ch;margin-bottom:18px;">
      Cualquier monto se vuelve mercado, medicina o un abrazo más.
    </h1>
    <p style="color:rgba(255,255,255,.92);font-size:19px;max-width:60ch;margin:0;line-height:1.6;">
      Elige el medio que más te acomode. Aquí están todos los datos para hacer tu aporte directo a la fundación.
    </p>
  </div>
</section>

@if($hasAnyDonation)

{{-- JUMP NAV --}}
<nav class="jump-nav" aria-label="Saltar a método de donación">
  <div class="don-container">
    @if($hasBankInfo)
    <a href="#bancolombia" class="js-don-jump is-active">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <path d="M3 21h18"/><path d="M3 10h18"/><path d="M5 6l7-3 7 3"/>
        <path d="M4 10v11"/><path d="M20 10v11"/>
        <path d="M8 14v4"/><path d="M12 14v4"/><path d="M16 14v4"/>
      </svg>
      Transferencia bancaria
    </a>
    @endif
    @if($hasNequi)
    <a href="#nequi" class="js-don-jump">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <rect x="5" y="2" width="14" height="20" rx="2"/><path d="M12 18h.01"/>
      </svg>
      Nequi
    </a>
    @endif
    @if($hasDaviplata)
    <a href="#daviplata" class="js-don-jump">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <rect x="5" y="2" width="14" height="20" rx="2"/><path d="M12 18h.01"/>
      </svg>
      Daviplata
    </a>
    @endif
    @if($hasQr)
    <a href="#qr" class="js-don-jump">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
        <path d="M14 14h3v3M21 14v.01M14 21h.01M21 21v-3M17 17v.01"/>
      </svg>
      Código QR
    </a>
    @endif
    <a href="#otras" class="js-don-jump">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
      </svg>
      Otras formas
    </a>
  </div>
</nav>

{{-- METHODS --}}
<section class="methods">
  <div class="don-container">

    {{-- Bancolombia --}}
    @if($hasBankInfo)
    <article class="method" id="bancolombia" style="margin-bottom:24px;">
      <div class="method-header">
        <div class="method-logo bancolombia" aria-hidden="true">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M3 21h18"/><path d="M3 10h18"/><path d="M5 6l7-3 7 3"/>
            <path d="M4 10v11"/><path d="M20 10v11"/>
            <path d="M8 14v4"/><path d="M12 14v4"/><path d="M16 14v4"/>
          </svg>
        </div>
        <div class="method-title">
          <h3>Transferencia bancaria</h3>
          <span>
            @if($siteSettings->donation_bank_name){{ $siteSettings->donation_bank_name }}@endif
            @if($siteSettings->donation_bank_name && $siteSettings->donation_account_type) · @endif
            @if($siteSettings->donation_account_type){{ $siteSettings->donation_account_type }}@endif
          </span>
        </div>
      </div>
      <div class="method-body">
        @if($siteSettings->donation_bank_name)
        <div class="field">
          <div>
            <div class="field-label">Banco</div>
            <div class="field-value">{{ $siteSettings->donation_bank_name }}</div>
          </div>
          <button class="copy-btn js-don-copy" data-copy="{{ $siteSettings->donation_bank_name }}" aria-label="Copiar nombre del banco">
            <span class="label-default">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/></svg>
              Copiar
            </span>
            <span class="label-copied" style="display:none;">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
              Copiado
            </span>
          </button>
        </div>
        @endif

        @if($siteSettings->donation_account_type)
        <div class="field">
          <div>
            <div class="field-label">Tipo de cuenta</div>
            <div class="field-value">{{ $siteSettings->donation_account_type }}</div>
          </div>
          <button class="copy-btn js-don-copy" data-copy="{{ $siteSettings->donation_account_type }}" aria-label="Copiar tipo de cuenta">
            <span class="label-default">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/></svg>
              Copiar
            </span>
            <span class="label-copied" style="display:none;">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
              Copiado
            </span>
          </button>
        </div>
        @endif

        @if($siteSettings->donation_account)
        <div class="field">
          <div>
            <div class="field-label">Número de cuenta</div>
            <div class="field-value mono">{{ $siteSettings->donation_account }}</div>
          </div>
          <button class="copy-btn js-don-copy" data-copy="{{ preg_replace('/[^0-9]/', '', $siteSettings->donation_account) }}" aria-label="Copiar número de cuenta">
            <span class="label-default">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/></svg>
              Copiar
            </span>
            <span class="label-copied" style="display:none;">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
              Copiado
            </span>
          </button>
        </div>
        @endif

        @if($siteSettings->donation_account_holder)
        <div class="field">
          <div>
            <div class="field-label">Titular</div>
            <div class="field-value" style="font-size:15px;">{{ $siteSettings->donation_account_holder }}</div>
          </div>
          <button class="copy-btn js-don-copy" data-copy="{{ $siteSettings->donation_account_holder }}" aria-label="Copiar titular de la cuenta">
            <span class="label-default">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/></svg>
              Copiar
            </span>
            <span class="label-copied" style="display:none;">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
              Copiado
            </span>
          </button>
        </div>
        @endif

        @if($siteSettings->donation_nit_bank)
        <div class="field">
          <div>
            <div class="field-label">NIT</div>
            <div class="field-value mono">{{ $siteSettings->donation_nit_bank }}</div>
          </div>
          <button class="copy-btn js-don-copy" data-copy="{{ preg_replace('/[^0-9]/', '', $siteSettings->donation_nit_bank) }}" aria-label="Copiar NIT">
            <span class="label-default">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/></svg>
              Copiar
            </span>
            <span class="label-copied" style="display:none;">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
              Copiado
            </span>
          </button>
        </div>
        @endif
      </div>
    </article>
    @endif

    {{-- Nequi + Daviplata grid --}}
    @if($hasNequi || $hasDaviplata)
    <div class="methods-grid">

      @if($hasNequi)
      <article class="method" id="nequi">
        <div class="method-header">
          <div class="method-logo nequi">
            <img src="{{ asset('images/logo-nequi.png') }}" alt="Nequi" loading="lazy">
          </div>
          <div class="method-title">
            <h3>Nequi</h3>
            <span>Billetera digital</span>
          </div>
        </div>
        <div class="method-body">
          <div class="field">
            <div>
              <div class="field-label">Número de Nequi</div>
              <div class="field-value mono">{{ $siteSettings->donation_nequi }}</div>
            </div>
            <button class="copy-btn js-don-copy" data-copy="{{ preg_replace('/[^0-9]/', '', $siteSettings->donation_nequi) }}" aria-label="Copiar número de Nequi">
              <span class="label-default">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/></svg>
                Copiar
              </span>
              <span class="label-copied" style="display:none;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
                Copiado
              </span>
            </button>
          </div>
          <div class="field" style="border-bottom:0;">
            <div style="font-size:13px;color:#5A6A6E;line-height:1.55;">
              Abre tu app Nequi → <strong style="color:#1F2A2E;">Enviar</strong> → A un celular → Pega el número.
            </div>
          </div>
        </div>
      </article>
      @endif

      @if($hasDaviplata)
      <article class="method" id="daviplata">
        <div class="method-header">
          <div class="method-logo daviplata">
            <img src="{{ asset('images/logo-daviplata.png') }}" alt="DaviPlata" loading="lazy">
          </div>
          <div class="method-title">
            <h3>Daviplata</h3>
            <span>Billetera digital</span>
          </div>
        </div>
        <div class="method-body">
          <div class="field">
            <div>
              <div class="field-label">Número de Daviplata</div>
              <div class="field-value mono">{{ $siteSettings->donation_daviplata }}</div>
            </div>
            <button class="copy-btn js-don-copy" data-copy="{{ preg_replace('/[^0-9]/', '', $siteSettings->donation_daviplata) }}" aria-label="Copiar número de Daviplata">
              <span class="label-default">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/></svg>
                Copiar
              </span>
              <span class="label-copied" style="display:none;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
                Copiado
              </span>
            </button>
          </div>
          <div class="field" style="border-bottom:0;">
            <div style="font-size:13px;color:#5A6A6E;line-height:1.55;">
              Abre tu app Daviplata → <strong style="color:#1F2A2E;">Pasa la plata</strong> → Otro Daviplata → Pega el número.
            </div>
          </div>
        </div>
      </article>
      @endif

    </div>
    @endif

  </div>
</section>

{{-- QR --}}
@if($hasQr)
<section class="qr-section" id="qr">
  <div class="don-container">
    <div class="qr-card">
      <div class="qr-visual">
        <div class="qr-frame">
          <img
            src="{{ Storage::url($siteSettings->donationQr->file_path) }}"
            alt="{{ $siteSettings->donationQr->alt_text ?: 'Código QR para donación' }}"
            class="qr-img"
            loading="lazy"
          >
        </div>
        <a href="{{ Storage::url($siteSettings->donationQr->file_path) }}"
           download="QR-Donacion-Hogar-Nazareth"
           target="_blank"
           class="qr-download-btn"
           aria-label="Descargar código QR para donación">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
            <polyline points="7 10 12 15 17 10"/>
            <line x1="12" y1="15" x2="12" y2="3"/>
          </svg>
          Descargar QR
        </a>
      </div>
      <div class="qr-content">
        <span class="don-eyebrow gold">Donar escaneando</span>
        <h2 class="don-h2" style="font-size:clamp(26px,3vw,34px);margin-bottom:14px;color:#0A6B73;">
          Apunta tu cámara y listo
        </h2>
        <p style="font-size:16px;margin-bottom:24px;color:#4B5A5E;">
          Si prefieres no copiar números, escanea este código desde tu app bancaria o billetera digital y abrirá la transferencia directamente con nuestros datos cargados.
        </p>
        <ol class="qr-steps">
          <li><span class="num">1</span><span>Abre la app de tu banco o billetera</span></li>
          <li><span class="num">2</span><span>Toca la opción <strong>Pagar con QR</strong></span></li>
          <li><span class="num">3</span><span>Apunta al código y confirma el monto</span></li>
        </ol>
      </div>
    </div>
  </div>
</section>
@endif

@else

{{-- Fallback: sin datos configurados --}}
<section style="background:#FBFBF9;padding:80px 0;">
  <div class="don-container">
    <div style="text-align:center;padding:64px 24px;background:#fff;border-radius:20px;border:1px solid #E3EAEB;max-width:560px;margin:0 auto;">
      <svg class="mx-auto mb-4" style="width:56px;height:56px;color:#C9E3E6;display:block;margin:0 auto 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
              d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
      </svg>
      <p style="font-size:18px;font-weight:600;color:#1F2A2E;margin-bottom:8px;">
        Para información sobre donaciones, contáctenos directamente
      </p>
      <p style="font-size:15px;color:#4B5A5E;margin-bottom:24px;">
        Estaremos encantados de orientarle sobre cómo puede apoyar nuestra misión.
      </p>
      <a href="{{ route('website.contact') }}"
         style="display:inline-flex;align-items:center;background:#E8A020;color:#fff;font-weight:600;padding:12px 24px;border-radius:10px;font-size:15px;text-decoration:none;transition:background .15s;"
         onmouseover="this.style.background='#C6851A'" onmouseout="this.style.background='#E8A020'">
        Contáctenos
      </a>
    </div>
  </div>
</section>

@endif

{{-- WHY GIVE --}}
<section class="why">
  <div class="don-container">
    <div class="why-grid">
      <div class="why-quote">
        <span class="mark" aria-hidden="true">"</span>
        <blockquote>Honra a tu padre y a tu madre. Donde hay un anciano, hay memoria, hay raíz, hay futuro. Cuidarlos no es caridad: es devolver lo que un día nos dieron.</blockquote>
        <cite>
          <strong>Fundación Centro de Bienestar del Anciano Nazareth</strong>
          Misión que nos sostiene desde 1985
        </cite>
      </div>

      <div class="why-reasons">
        <div class="why-reason">
          <div class="ic" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
            </svg>
          </div>
          <div>
            <h3 class="don-h3">Nadie envejece solo aquí</h3>
            <p>Tu donación se traduce en compañía diaria, comida caliente y un techo seguro para abuelos que la vida dejó sin familia cerca.</p>
          </div>
        </div>

        <div class="why-reason">
          <div class="ic" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
            </svg>
          </div>
          <div>
            <h3 class="don-h3">Cada peso llega completo</h3>
            <p>No usamos pasarelas ni intermediarios. El 100% de tu aporte entra directo a la cuenta de la fundación y se usa en alimentación, medicinas y servicios.</p>
          </div>
        </div>

        <div class="why-reason">
          <div class="ic" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M12 22s-8-4.5-8-11.5a5.5 5.5 0 0 1 11-1 5.5 5.5 0 0 1 11 1c0 7-8 11.5-8 11.5"/>
            </svg>
          </div>
          <div>
            <h3 class="don-h3">Lo que das, lo ves</h3>
            <p>Publicamos cada año el destino de los recursos. Si donas, te invitamos a visitar el hogar y conocer a quienes se benefician de tu aporte.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- OTRAS FORMAS --}}
<section class="other-ways" id="otras">
  <div class="don-container">
    <div class="don-section-head">
      <span class="don-eyebrow teal">Sin dinero también se ayuda</span>
      <h2 class="don-h2">Otras formas de estar presentes</h2>
      <p>Si no puedes donar dinero hoy, hay otros caminos para que el hogar te tenga en cuenta.</p>
    </div>
    <div class="other-grid">
      <article class="other-card">
        <div class="icon-box">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
            <circle cx="8.5" cy="7" r="4"/>
            <path d="M20 8v6M23 11h-6"/>
          </svg>
        </div>
        <h3>Voluntariado</h3>
        <p>Regala una tarde. Jugar parqués, peinar, leer el periódico, enseñar una canción. Nos organizamos según tu disponibilidad.</p>
        <a href="{{ route('website.contact') }}" class="link">
          Quiero ser voluntario
          <svg style="width:14px;height:14px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
      </article>

      <article class="other-card">
        <div class="icon-box">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/>
            <path d="M3.27 6.96L12 12.01l8.73-5.05M12 22.08V12"/>
          </svg>
        </div>
        <h3>Donaciones en especie</h3>
        <p>Pañales, toallas higiénicas, productos de aseo, cobijas, mercado seco. Avísanos qué tienes y coordinamos la recogida.</p>
        <a href="{{ route('website.contact') }}" class="link">
          Coordinar entrega
          <svg style="width:14px;height:14px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
      </article>

      <article class="other-card">
        <div class="icon-box">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M22 11.08V12a10 10 0 11-5.93-9.14"/>
            <path d="M22 4L12 14.01l-3-3"/>
          </svg>
        </div>
        <h3>Empresas aliadas</h3>
        <p>Convenios anuales, donaciones recurrentes, jornadas de voluntariado corporativo. Hablamos de lo que tu empresa puede aportar.</p>
        <a href="{{ route('website.contact') }}" class="link">
          Hablar con nosotros
          <svg style="width:14px;height:14px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
      </article>
    </div>
  </div>
</section>

{{-- TRUST BAND --}}
<section class="trust">
  <div class="don-container">
    <div class="trust-grid">
      <div>
        <h3 class="don-h3" style="color:#fff;font-size:24px;margin-bottom:12px;">Cuentas claras, siempre</h3>
        <p>Somos entidad sin ánimo de lucro registrada ante la DIAN como Régimen Tributario Especial. Publicamos cada año los estados financieros y el destino de cada peso donado.</p>
      </div>
      <div class="trust-cta">
        <a href="{{ route('website.documents.index') }}" class="btn-trust-primary">Ver reportes públicos</a>
      </div>
    </div>
  </div>
</section>

{{-- Toast --}}
<div class="don-toast" id="don-toast" role="status" aria-live="polite">
  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
    <path d="M20 6L9 17l-5-5"/>
  </svg>
  <span id="don-toast-msg">Copiado al portapapeles</span>
</div>

@endsection

@push('scripts')
<script>
(function () {
  // ── Copy buttons ─────────────────────────────────────────────────────────
  const toast    = document.getElementById('don-toast');
  const toastMsg = document.getElementById('don-toast-msg');
  let toastTimer;

  function showToast(msg) {
    toastMsg.textContent = msg;
    toast.classList.add('show');
    clearTimeout(toastTimer);
    toastTimer = setTimeout(() => toast.classList.remove('show'), 2000);
  }

  document.querySelectorAll('.js-don-copy').forEach(btn => {
    btn.addEventListener('click', async () => {
      const value = btn.dataset.copy;
      try {
        await navigator.clipboard.writeText(value);
      } catch {
        const ta = document.createElement('textarea');
        ta.value = value;
        document.body.appendChild(ta);
        ta.select();
        document.execCommand('copy');
        ta.remove();
      }
      btn.classList.add('copied');
      const defaultSpan = btn.querySelector('.label-default');
      const copiedSpan  = btn.querySelector('.label-copied');
      if (defaultSpan) defaultSpan.style.display = 'none';
      if (copiedSpan)  copiedSpan.style.display  = 'inline-flex';
      showToast('Copiado: ' + value);
      setTimeout(() => {
        btn.classList.remove('copied');
        if (defaultSpan) defaultSpan.style.display = '';
        if (copiedSpan)  copiedSpan.style.display  = 'none';
      }, 1800);
    });
  });

  // ── Jump nav active state ─────────────────────────────────────────────────
  const jumpLinks = document.querySelectorAll('.js-don-jump');
  if (jumpLinks.length) {
    const targets = [...jumpLinks]
      .map(a => document.querySelector(a.getAttribute('href')))
      .filter(Boolean);

    function updateActive() {
      const scrollY = window.scrollY + 145;
      let activeIdx = 0;
      targets.forEach((t, i) => { if (t && t.offsetTop <= scrollY) activeIdx = i; });
      jumpLinks.forEach((a, i) => a.classList.toggle('is-active', i === activeIdx));
    }

    window.addEventListener('scroll', updateActive, { passive: true });
    updateActive();

    jumpLinks.forEach(a => {
      a.addEventListener('click', e => {
        e.preventDefault();
        const target = document.querySelector(a.getAttribute('href'));
        if (target) {
          const top = target.getBoundingClientRect().top + window.scrollY - 130;
          window.scrollTo({ top, behavior: 'smooth' });
        }
      });
    });
  }
})();
</script>
@endpush
