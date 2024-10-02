<?php

namespace App\Http\Resources;

use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Crypt;
use JetBrains\PhpStorm\ArrayShape;

class FormResource extends JsonResource
{
    /** @var Form */
    public $resource;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    #[ArrayShape(['id' => "mixed", 'name' => "mixed", 'description' => "mixed", 'display' => "string", 'fields' => "mixed", 'created_at' => "mixed", 'updated_at' => "mixed"])]
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->getAttribute('id'),
            'name' => $this->resource->getAttribute('name'),
            'description' => $this->resource->getAttribute('description'),
            'display' => Crypt::encryptString($this->resource->getAttribute('id')),
            'fields' => FormFieldResource::collection($this->whenLoaded('fields')),
            'created_at' => $this->resource->getAttribute('created_at')->toDateTimeString(),
            'updated_at' => $this->resource->getAttribute('updated_at')->toDateTimeString(),
        ];
    }
}
