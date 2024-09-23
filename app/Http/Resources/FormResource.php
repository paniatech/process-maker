<?php

namespace App\Http\Resources;

use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
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
    #[ArrayShape(['id' => "mixed", 'name' => "mixed", 'description' => "mixed", 'created_at' => "mixed", 'updated_at' => "mixed"])]
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->getAttribute('id'),
            'name' => $this->resource->getAttribute('name'),
            'description' => $this->resource->getAttribute('description'),
            'created_at' => $this->resource->getAttribute('created_at')->toDateTimeString(),
            'updated_at' => $this->resource->getAttribute('updated_at')->toDateTimeString(),
        ];
    }
}
