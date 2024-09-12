<?php

namespace App\Http\Resources\General\BranchOffice;

use App\Http\Resources\Media\MediaSimpleResource;
use App\Models\General\BranchOffice;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/* @property BranchOffice $resource */
class BranchOfficeSimpleResource extends JsonResource
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
            'image' => new MediaSimpleResource($this->whenLoaded('image')),
        ];
    }
}
