<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title>Próximamente · Fundación Hogar del Anciano Nazareth</title>
<meta name="description" content="Estamos renovando nuestro sitio. Vuelve pronto para conocer nuestras actividades, galería y formas de apoyarnos.">
<link rel="icon" type="image/png" href="{{ asset('images/logo_fundacion_isotipo-2.png') }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&family=Fraunces:opsz,wght@9..144,500;9..144,600&display=swap" rel="stylesheet">
<style>
  :root {
    --nz-blue:   #0A6B73;
    --nz-light:  #19B0B8;
    --nz-700:    #10939C;
    --nz-200:    #9ED7DC;
    --nz-100:    #C9E3E6;
    --nz-50:     #EAF4F5;
    --nz-ink:    #1F2A2E;
    --nz-paper:  #FBFBF9;
    --nz-gold:   #E8A020;
    --nz-gold-dark: #C6851A;
    --nz-muted:  #5A6A6E;
    --nz-line:   #E3EAEB;
    --nz-text-soft: #4B5A5E;
  }

  * { box-sizing: border-box; }
  html, body { margin: 0; padding: 0; }
  body {
    min-height: 100vh;
    font-family: 'Figtree', -apple-system, BlinkMacSystemFont, "Helvetica Neue", Helvetica, Arial, sans-serif;
    color: var(--nz-ink);
    line-height: 1.55;
    -webkit-font-smoothing: antialiased;
    background: var(--nz-paper);
    display: flex;
    flex-direction: column;
  }
  img { display: block; max-width: 100%; }
  a { color: inherit; text-decoration: none; }

  /* ===== Stage ===== */
  .stage {
    flex: 1;
    display: grid;
    place-items: center;
    padding: 48px 24px;
    position: relative;
    overflow: hidden;
    background:
      radial-gradient(ellipse at 50% 0%, rgba(158,215,220,.35) 0%, transparent 55%),
      radial-gradient(ellipse at 80% 110%, rgba(232,160,32,.10) 0%, transparent 50%),
      var(--nz-paper);
  }

  /* Decorative concentric rings */
  .stage::before, .stage::after {
    content: '';
    position: absolute;
    border-radius: 50%;
    border: 1px solid var(--nz-100);
    pointer-events: none;
  }
  .stage::before {
    width: 680px; height: 680px;
    top: 50%; left: 50%;
    transform: translate(-50%, -50%);
    opacity: .65;
  }
  .stage::after {
    width: 1080px; height: 1080px;
    top: 50%; left: 50%;
    transform: translate(-50%, -50%);
    border-color: var(--nz-100);
    opacity: .35;
  }

  /* Card */
  .card {
    position: relative;
    z-index: 1;
    max-width: 640px;
    width: 100%;
    text-align: center;
    padding: 16px 24px;
  }

  .logo {
    height: 120px;
    width: auto;
    margin: 0 auto 28px;
    display: block;
  }
  @media (max-width: 540px) { .logo { height: 96px; } }

  .badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #fff;
    color: var(--nz-700);
    padding: 6px 14px 6px 8px;
    border: 1px solid var(--nz-100);
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: .14em;
    text-transform: uppercase;
    margin-bottom: 24px;
    box-shadow: 0 1px 2px rgba(10,107,115,.04);
  }
  .badge .dot {
    width: 8px; height: 8px;
    border-radius: 50%;
    background: var(--nz-gold);
    box-shadow: 0 0 0 4px rgba(232,160,32,.22);
    animation: pulse 2.4s ease-in-out infinite;
  }
  @keyframes pulse {
    0%, 100% { box-shadow: 0 0 0 4px rgba(232,160,32,.22); }
    50%      { box-shadow: 0 0 0 8px rgba(232,160,32,.08); }
  }

  h1 {
    font-family: 'Fraunces', Georgia, serif;
    font-size: clamp(36px, 6vw, 56px);
    font-weight: 600;
    line-height: 1.05;
    letter-spacing: -.02em;
    color: var(--nz-blue);
    margin: 0 0 18px;
    text-wrap: balance;
  }
  h1 em {
    font-style: italic;
    font-weight: 500;
    color: var(--nz-gold);
  }

  .lede {
    font-size: 17px;
    color: var(--nz-text-soft);
    max-width: 52ch;
    margin: 0 auto 28px;
    text-wrap: pretty;
  }

  .institutional {
    font-size: 13px;
    color: var(--nz-muted);
    letter-spacing: .04em;
    margin: 0 0 6px;
  }

  .cta-row {
    display: flex;
    gap: 12px;
    justify-content: center;
    flex-wrap: wrap;
    margin-top: 8px;
  }
  .btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 13px 22px;
    border-radius: 999px;
    font-size: 15px;
    font-weight: 600;
    font-family: inherit;
    cursor: pointer;
    border: 2px solid transparent;
    transition: all .15s;
    line-height: 1;
    text-decoration: none;
  }
  .btn-primary {
    background: #1877F2;
    color: #fff;
    border-color: #1877F2;
  }
  .btn-primary:hover {
    background: #1665d8;
    border-color: #1665d8;
    transform: translateY(-1px);
  }
  .btn-ghost {
    background: #fff;
    color: var(--nz-blue);
    border-color: var(--nz-200);
  }
  .btn-ghost:hover {
    border-color: var(--nz-light);
    color: var(--nz-light);
  }
  .btn svg { width: 18px; height: 18px; }

  /* Contact strip */
  .contact-strip {
    margin-top: 36px;
    padding-top: 28px;
    border-top: 1px solid var(--nz-100);
    display: flex;
    gap: 28px;
    justify-content: center;
    flex-wrap: wrap;
    font-size: 14px;
    color: var(--nz-muted);
  }
  .contact-strip a {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: var(--nz-text-soft);
    transition: color .15s;
  }
  .contact-strip a:hover { color: var(--nz-blue); }
  .contact-strip svg { width: 16px; height: 16px; color: var(--nz-700); }

  /* Footer */
  footer.foot {
    text-align: center;
    padding: 24px;
    font-size: 12px;
    color: var(--nz-muted);
    border-top: 1px solid var(--nz-line);
    background: #fff;
  }
  footer.foot a {
    color: var(--nz-700);
    font-weight: 500;
  }
  footer.foot a:hover { text-decoration: underline; }
</style>
</head>
@php
  try {
      $s = App\Models\SiteSetting::instance();
  } catch (\Throwable) {
      $s = null;
  }
  $orgName   = $s?->org_name    ?? 'Fundación Centro de Bienestar del Anciano Nazareth';
  $facebook  = $s?->social_facebook ?? 'https://web.facebook.com/hogardelanciano.nazareth';
  $email     = $s?->contact_email   ?? null;
  $phone     = $s?->contact_phone   ?? null;
  $address   = $s?->contact_address ?? null;
  $phoneTel  = $phone ? 'tel:+57' . preg_replace('/\D/', '', $phone) : null;
@endphp
<body>

  <main class="stage">
    <div class="card">

      <img class="logo"
           src="{{ asset('images/logo_fundacion_isotipo-2.png') }}"
           alt="{{ $orgName }}"
           width="320" height="320" />

      <span class="badge">
        <span class="dot" aria-hidden="true"></span>
        Próximamente
      </span>

      <p class="institutional">{{ $orgName }}</p>

      <h1>Estamos renovando <em>nuestro sitio</em></h1>

      <p class="lede">
        La Fundación está preparando una nueva experiencia digital. Vuelve pronto para conocer nuestras actividades, galería y formas de apoyarnos.
      </p>

      <p class="lede" style="margin-bottom:32px;">
        Mientras tanto, síguenos en Facebook para estar al tanto de nuestras actividades.
      </p>

      <div class="cta-row">
        <a href="{{ $facebook }}" target="_blank" rel="noopener" class="btn btn-primary">
          <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
          </svg>
          Síguenos en Facebook
        </a>
        @if($email)
        <a href="mailto:{{ $email }}" class="btn btn-ghost">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
          </svg>
          Escríbenos
        </a>
        @endif
      </div>

      @if($phone || $address)
      <div class="contact-strip">
        @if($phone)
        <a href="{{ $phoneTel }}">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
          {{ $phone }}
        </a>
        @endif
        @if($address)
        <span style="display:inline-flex;align-items:center;gap:8px;">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M17.66 16.66L13.41 20.9a1.99 1.99 0 01-2.82 0l-4.24-4.25a8 8 0 1111.31 0z"/><circle cx="12" cy="11" r="3"/></svg>
          {{ $address }}
        </span>
        @endif
      </div>
      @endif

    </div>
  </main>

  <footer class="foot">
    © {{ date('Y') }} {{ $orgName }} ·
    Sitio en construcción por
    <a href="https://www.linkedin.com/in/jorgecarrillog/" target="_blank" rel="noopener">Jorge Carrillo</a>
    para la
    <a href="https://www.autonoma.edu.co/" target="_blank" rel="noopener">Universidad Autónoma de Manizales</a>
  </footer>

</body>
</html>
