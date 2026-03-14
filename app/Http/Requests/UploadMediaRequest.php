<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validates file uploads: images (JPEG, PNG, WEBP, GIF) and PDF documents up to 10 MB.
 */
final class UploadMediaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /** @return array<string, list<string>> */
    public function rules(): array
    {
        return [
            'file' => ['required', 'file', 'mimes:jpeg,jpg,png,webp,gif,pdf', 'max:10240'],
        ];
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return [
            'file.required' => 'Debes seleccionar un archivo.',
            'file.file'     => 'El archivo no es válido.',
            'file.mimes'    => 'Solo se permiten imágenes (JPEG, PNG, WEBP, GIF) y documentos PDF.',
            'file.max'      => 'El archivo no puede superar los 10 MB.',
        ];
    }
}
