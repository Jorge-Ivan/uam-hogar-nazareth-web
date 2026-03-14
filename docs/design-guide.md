# Design Guide — Hogar Nazareth Web Platform

> Load this file when building any Blade view (Phase 3 admin layout or Phase 4 public site).
> All UI decisions must follow these patterns before writing any HTML/Tailwind.

---

## 1. Color Palette

```
Primary blue    #1B4B8A   — nav, headers, hero background, primary buttons
Blue light      #2D6CC2   — hover states, links, gradient complement
Golden amber    #E8A020   — CTA buttons (donate, action), accent badges
Section gray    #F5F7FA   — alternate section backgrounds
Green success   #3D7A45   — published status badges, success states
White           #FFFFFF   — card surfaces, content areas
Text primary    #1A202C   — body text
Text secondary  #4A5568   — secondary labels, captions
```

### Tailwind config mapping
```js
colors: {
  nazareth: {
    blue:   '#1B4B8A',
    light:  '#2D6CC2',
    gold:   '#E8A020',
    gray:   '#F5F7FA',
    green:  '#3D7A45',
  }
}
```

---

## 2. Typography

- Body minimum: `text-base` (16px) — elderly visitors and families read on mobile
- Headings: `font-medium` (500 weight) — never bold/700 in body copy
- Line height: `leading-relaxed` on body paragraphs
- High contrast always: blue #1B4B8A on white passes WCAG AA

---

## 3. Key UI Patterns (from Colombian foundation analysis)

### 3.1 Sticky navbar with always-visible donation CTA
Inspired by: Fundación Juan Pablo II, Fundación Jeymar

```
[Logo]  Nosotros | Actividades | Galerías | Transparencia | Contacto   [Apoyar ❤]
```

- Logo on left, white on blue background (`bg-nazareth-blue`)
- Nav links in `text-white/80`, hover `text-white`
- "Apoyar" button: `bg-nazareth-gold text-white` — always visible, sticky on scroll
- Mobile: hamburger menu (Alpine.js `x-data` toggle)

### 3.2 Hero section
- Full-width, blue gradient background (`from-nazareth-blue to-nazareth-light`)
- Real photo of residents as background (overlay `bg-nazareth-blue/70`)
- Tag line: foundation category in small amber badge
- H1: mission statement, max 12 words, large and clear
- 2 CTAs: primary (donation, gold) + secondary (learn more, outline white)
- Impact counter row below: years of service / residents / volunteers

### 3.3 Activities grid
- 3 columns desktop, 2 tablet, 1 mobile
- Each card: photo (aspect-video) + date + title
- Date in `text-sm text-gray-400`
- Title in `font-medium text-gray-900`
- Hover: subtle shadow, image slight zoom (`group-hover:scale-105 transition`)
- "Ver todas las actividades →" link at the bottom

### 3.4 How to support (3 cards)
Inspired by: Fundación Juan Pablo II participación section

```
[ Donación monetaria ]  [ Donación en especie ]  [ Voluntariado ]
```

- Icon + title + 2-line description + CTA link
- Cards on `bg-nazareth-gray` section background
- Border-left accent in `nazareth-gold` on each card

### 3.5 Upcoming events
- Compact list, max 3 future events
- Each item: date badge (day/month) + title + location
- Date badge: `bg-nazareth-blue text-white rounded`
- "Ver todos los eventos →" link

### 3.6 Gallery section
- Grid 3 cols, images from GalleryImage model (eager loaded with Gallery)
- Alpine.js lightbox on click
- Gallery title overlay on hover

### 3.7 Transparency footer band
Inspired by: Fundación Jeymar, legal requirement (DIAN)

- Dark band (`bg-nazareth-blue text-white`) before main footer
- Links to: Documentos DIAN / Informes anuales / Política de datos
- Statement: "Administración transparente de donaciones"

### 3.8 Footer
- 3 columns: institutional links / contact info / social networks
- Social: Facebook (primary channel), WhatsApp, Instagram
- Copyright + "Todos los derechos reservados"

---

## 4. Admin Panel Patterns

### 4.1 Admin layout
- Sidebar left (dark: `bg-gray-900 text-white`), content area white
- Logo + foundation name at top of sidebar
- Nav items with icons, active state: `bg-nazareth-blue/10 text-nazareth-blue border-l-2 border-nazareth-blue`
- Top bar: page title + user menu

### 4.2 Content tables (Livewire)
- Status badges: Draft=gray, Published=green, Archived=yellow
- Search input at top right of table
- Action buttons: Edit (blue) / Publish inline toggle / Delete (red, confirm modal)
- Pagination at bottom

### 4.3 Forms
- Labels in Spanish, above inputs
- Required fields marked with `*` in red
- Slug field: auto-generated from title, editable, shown below title
- Featured image: upload zone with preview
- Status selector: Draft / Published / Archived (radio or select)
- Save buttons: "Guardar borrador" (gray) + "Publicar" (green)

### 4.4 Media uploader
- Drag and drop zone with dashed border
- Progress bar on upload
- Preview grid after upload
- Alt text field required for accessibility

---

## 5. Mobile-first Notes

The foundation's audience comes primarily from Facebook (mobile users).

- Design every view for 375px width first
- Hamburger menu required on public nav
- Activity cards stack to 1 column on mobile
- Hero CTAs stack vertically on mobile
- Gallery: 1 col mobile, 2 tablet, 3 desktop
- Font sizes never below `text-sm` (14px) anywhere

---

## 6. Accessibility Requirements

- All images must use `alt="{{ $media->alt_text }}"` from Media model
- Color contrast: all text on colored backgrounds must pass WCAG AA
- Semantic HTML: `<nav>`, `<main>`, `<article>`, `<section>`, `<footer>`
- Focus rings on all interactive elements (`focus:ring-2 focus:ring-nazareth-blue`)
- Skip-to-content link at top of public layout

---

## 7. Content Tone

- Warm, dignified, community-focused
- Avoid clinical language — this is a home, not a medical facility
- Use: "nuestros adultos mayores", "residentes", "familia Nazareth"
- Avoid: "pacientes", "usuarios", "beneficiarios" (too clinical)
- Donation CTAs: "Apoyar", "Contribuir", "Hacer una donación" — never "Give now" patterns

---

## 8. Reference Sites Analyzed

- Fundación Juan Pablo II: https://fundacionjuanpabloii.com/ — structure, emotional storytelling, participation patterns
- Fundación Jeymar: https://fundacionjeymar.org/ — transparency section, multiple donation options, video gallery
- Fundación La Manuelita: https://lamanuelita.org/ — donation in-kind, long history storytelling
- Pura Vida Fundación: https://www.puravidafundacion.org/ — modern design for Colombian elderly care