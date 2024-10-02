<?php

namespace App\Http\Resources;

use App\Models\FormSubmission;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\ArrayShape;

class FormSubmissionResource extends JsonResource
{
    /** @var FormSubmission */
    public $resource;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    #[ArrayShape(['id' => "mixed", 'submitted_at' => "mixed", 'payloads' => "mixed"])]
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->getAttribute('id'),
            'submitted_at' => $this->resource->getAttribute('submitted_at'),
            'payloads' => $this->whenLoaded('payloads'),
        ];
    }
}
