<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\ContentStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StorePageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return [
            'title'   => ['required', 'string', 'max:255'],
            'slug'    => ['nullable', 'string', 'max:255', 'unique:pages,slug'],
            'content' => ['required', 'string'],
            'status'  => ['nullable', Rule::enum(ContentStatus::class)],
        ];
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return [
            'title.required'   => 'El título es obligatorio.',
            'title.max'        => 'El título no puede superar los 255 caracteres.',
            'content.required' => 'El contenido es obligatorio.',
            'slug.unique'      => 'Ya existe una página con esta URL.',
            'status.enum'      => 'El estado seleccionado no es válido.',
        ];
    }
}
