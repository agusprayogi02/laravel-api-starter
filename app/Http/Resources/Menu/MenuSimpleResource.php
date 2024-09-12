<?php

namespace App\Http\Resources\Menu;

use App\Models\Menu\Menu;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/* @var Menu $resource */
class MenuSimpleResource extends JsonResource
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
            'slug' => $this->resource->slug,
            'icon' => $this->resource->icon,
            'route' => $this->resource->route,
            'level' => $this->resource->level,
            'order' => $this->resource->order,
        ];
    }
}
