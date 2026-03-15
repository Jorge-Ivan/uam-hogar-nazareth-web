<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class StoreDocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return [
            'title'                => ['required', 'string', 'max:255'],
            'description'          => ['nullable', 'string'],
            'document_category_id' => ['required', 'integer', 'exists:document_categories,id'],
            'document_year_id'     => ['required', 'integer', 'exists:document_years,id'],
            'media_id'             => ['required', 'integer', 'exists:media,id'],
        ];
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return [
            'title.required'                => 'El título es obligatorio.',
            'title.max'                     => 'El título no puede superar los 255 caracteres.',
            'document_category_id.required' => 'La categoría es obligatoria.',
            'document_category_id.exists'   => 'La categoría seleccionada no existe.',
            'document_year_id.required'     => 'El año es obligatorio.',
            'document_year_id.exists'       => 'El año seleccionado no existe.',
            'media_id.required'             => 'Debe adjuntar un archivo.',
            'media_id.exists'               => 'El archivo seleccionado no existe.',
        ];
    }
}
