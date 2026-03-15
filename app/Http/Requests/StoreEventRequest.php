<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class StoreEventRequest extends FormRequest
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
            'slug'              => ['nullable', 'string', 'max:255', 'unique:events,slug'],
            'description'       => ['nullable', 'string'],
            'start_date'        => ['required', 'date'],
            'end_date'          => ['nullable', 'date', 'after_or_equal:start_date'],
            'location'          => ['nullable', 'string', 'max:255'],
            'featured_image_id' => ['nullable', 'integer', 'exists:media,id'],
        ];
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return [
            'title.required'           => 'El título es obligatorio.',
            'title.max'                => 'El título no puede superar los 255 caracteres.',
            'start_date.required'      => 'La fecha de inicio es obligatoria.',
            'start_date.date'          => 'La fecha de inicio no es válida.',
            'end_date.date'            => 'La fecha de fin no es válida.',
            'end_date.after_or_equal'  => 'La fecha de fin debe ser igual o posterior a la fecha de inicio.',
            'slug.unique'              => 'Ya existe un evento con esta URL.',
            'location.max'             => 'La ubicación no puede superar los 255 caracteres.',
            'featured_image_id.exists' => 'La imagen seleccionada no existe.',
        ];
    }
}
