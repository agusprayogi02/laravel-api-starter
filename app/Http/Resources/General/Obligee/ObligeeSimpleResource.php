<?php

namespace App\Http\Resources\General\Obligee;

use App\Models\General\Obligee;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/* @property Obligee $resource */
class ObligeeSimpleResource extends JsonResource
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
        ];
    }
}
