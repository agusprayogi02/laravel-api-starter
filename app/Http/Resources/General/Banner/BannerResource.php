<?php

namespace App\Http\Resources\General\Banner;

use App\Http\Resources\Media\MediaSimpleResource;
use App\Models\General\Banner;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/* @property Banner $resource */
class BannerResource extends JsonResource
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
            'order' => $this->resource->order,
            'is_active' => $this->resource->is_active,
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
            'deleted_at' => $this->resource->deleted_at,
            'image' => new MediaSimpleResource($this->whenLoaded('image')),
        ];
    }
}
