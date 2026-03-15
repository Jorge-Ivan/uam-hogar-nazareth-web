<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class AddGalleryImageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return [
            'media_id' => ['required', 'integer', 'exists:media,id'],
            'caption'  => ['nullable', 'string', 'max:255'],
        ];
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return [
            'media_id.required' => 'Debe seleccionar una imagen.',
            'media_id.exists'   => 'La imagen seleccionada no existe.',
            'caption.max'       => 'El pie de foto no puede superar los 255 caracteres.',
        ];
    }
}
