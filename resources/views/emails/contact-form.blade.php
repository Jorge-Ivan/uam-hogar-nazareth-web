Nuevo mensaje desde el formulario de contacto del sitio web.

Nombre:   {{ $data['name'] }}
Correo:   {{ $data['email'] }}
Teléfono: {{ $data['phone'] ?? 'No proporcionado' }}
Motivo:   {{ $data['subject'] ?? 'No especificado' }}

Mensaje:
{{ $data['message'] }}

---
Enviado desde el sitio web de Hogar Nazareth
