<?php

namespace App\Http\Resources\Principal;

use App\Models\Principal;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property  Principal $resource
 */
class PrincipalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'email' => $this->resource->email,
            'president_name' => $this->resource->president_name,
            'taxpayer_number' => $this->resource->taxpayer_number,
            'identification_number' => $this->resource->identification_number,
        ];
    }
}
