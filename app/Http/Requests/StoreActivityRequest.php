<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\ContentStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreActivityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return [
            'title'             => ['required', 'string', 'max:255'],
            'slug'              => ['nullable', 'string', 'max:255', 'unique:activities,slug'],
            'excerpt'           => ['nullable', 'string', 'max:500'],
            'content'           => ['required', 'string'],
            'featured_image_id' => ['nullable', 'integer', 'exists:media,id'],
            'status'            => ['nullable', Rule::enum(ContentStatus::class)],
            'published_at'      => ['nullable', 'date'],
        ];
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return [
            'title.required'          => 'El título es obligatorio.',
            'title.max'               => 'El título no puede superar los 255 caracteres.',
            'content.required'        => 'El contenido es obligatorio.',
            'slug.unique'             => 'Ya existe una actividad con esta URL.',
            'excerpt.max'             => 'El extracto no puede superar los 500 caracteres.',
            'featured_image_id.exists'=> 'La imagen seleccionada no existe.',
            'status.enum'             => 'El estado seleccionado no es válido.',
            'published_at.date'       => 'La fecha de publicación no es válida.',
        ];
    }
}
