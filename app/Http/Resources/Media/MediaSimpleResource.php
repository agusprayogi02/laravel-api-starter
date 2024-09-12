<?php

namespace App\Http\Resources\Media;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/* @property Media $resource */
class MediaSimpleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->resource->name,
            'file_name' => $this->resource->file_name,
            'mime_type' => $this->resource->mime_type,
            'size' => $this->resource->humanReadableSize,
            'original_url' => $this->resource->getUrl(),
            'preview_url' => $this->resource->getMediaConversionNames() == [] ?
                $this->resource->getUrl() :
                $this->resource->getUrl('thumb'),
        ];
    }
}
