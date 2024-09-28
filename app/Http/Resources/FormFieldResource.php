<?php

namespace App\Http\Resources;

use App\Models\FormField;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\ArrayShape;

class FormFieldResource extends JsonResource
{
    /** @var FormField */
    public $resource;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    #[ArrayShape(['id' => "mixed", 'name' => "mixed", 'label' => "mixed", 'type' => "mixed", 'options' => "mixed", 'is_required' => "mixed", 'created_at' => "mixed", 'updated_at' => "mixed"])]
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->getAttribute('id'),

            'name' => $this->resource->getAttribute('name'),
            'label' => $this->resource->getAttribute('label'),

            'type' => $this->resource->getAttribute('type'),
            'options' => $this->resource->getAttribute('options'),

            'is_required' => $this->resource->getAttribute('is_required'),

            'created_at' => $this->resource->getAttribute('created_at')->toDateTimeString(),
            'updated_at' => $this->resource->getAttribute('updated_at')->toDateTimeString(),
        ];
    }
}
