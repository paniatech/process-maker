<?php

namespace App\Http\Requests\Fields;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest as FoundationFormRequest;
use JetBrains\PhpStorm\ArrayShape;

class FiledRequest extends FoundationFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    #[ArrayShape(['fields' => "array", 'fields.*.name' => "string", 'fields.*.label' => "string", 'fields.*.type' => "string", 'fields.*.options' => "string", 'fields.*.is_required' => "bool"])]
    public function rules(): array
    {
        return [
            'fields' => 'required|array|min:1',
            'fields.*.name' => 'required|string',
            'fields.*.label' => 'required|string',
            'fields.*.type' => 'required|string',
            'fields.*.options' => 'nullable|array',
            'fields.*.is_required' => 'required|boolean',
        ];
    }
}
