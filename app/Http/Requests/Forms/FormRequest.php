<?php

namespace App\Http\Requests\Forms;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest as FoundationFormRequest;
use JetBrains\PhpStorm\ArrayShape;

class FormRequest extends FoundationFormRequest
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
    #[ArrayShape(['name' => "string", 'description' => "string"])]
    public function rules(): array
    {
        return [
            'name' => 'required',
            'description' => 'nullable',
        ];
    }
}
