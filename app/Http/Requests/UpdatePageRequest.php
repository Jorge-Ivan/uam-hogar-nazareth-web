<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\ContentStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdatePageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        $page = $this->route('page');

        return [
            'title'          => ['sometimes', 'required', 'string', 'max:255'],
            'slug'           => ['sometimes', 'nullable', 'string', 'max:255', Rule::unique('pages', 'slug')->ignore($page)],
            'content'        => ['sometimes', 'required', 'string'],
            'status'         => ['sometimes', 'nullable', Rule::enum(ContentStatus::class)],
            'parent_id'      => ['sometimes', 'nullable', 'integer', 'exists:pages,id'],
            'show_in_header' => ['sometimes', 'nullable', 'boolean'],
            'show_in_footer' => ['sometimes', 'nullable', 'boolean'],
            'menu_order'     => ['sometimes', 'nullable', 'integer', 'min:0'],
        ];
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return [
            'title.required'     => 'El título es obligatorio.',
            'title.max'          => 'El título no puede superar los 255 caracteres.',
            'content.required'   => 'El contenido es obligatorio.',
            'slug.unique'        => 'Ya existe una página con esta URL.',
            'status.enum'        => 'El estado seleccionado no es válido.',
            'parent_id.exists'   => 'La página superior seleccionada no existe.',
            'menu_order.integer' => 'El orden debe ser un número entero.',
            'menu_order.min'     => 'El orden no puede ser negativo.',
        ];
    }
}
