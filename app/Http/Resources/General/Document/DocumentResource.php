<?php

namespace App\Http\Resources\General\Document;

use App\Http\Resources\Media\MediaSimpleResource;
use App\Models\General\Document;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/* @property Document $resource */
class DocumentResource extends JsonResource
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
            'description' => $this->resource->description,
            'product_category_id' => $this->resource->product_category_id,
            'is_required' => $this->resource->is_required,
            'template' => new MediaSimpleResource($this->whenLoaded('template')),
            'order' => $this->resource->order,
            'is_active' => $this->resource->is_active,
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
            'deleted_at' => $this->resource->deleted_at,
        ];
    }
}
