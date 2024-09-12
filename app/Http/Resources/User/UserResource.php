<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Management\Roles\RoleResourceCollection;
use App\Http\Resources\Media\MediaSimpleResource;
use App\Http\Resources\Principal\PrincipalResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property  User $resource
 */
class UserResource extends JsonResource
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
            'username' => $this->resource->username,
            'phone' => $this->resource->phone,
            'email' => $this->resource->email,
            'photo' => new MediaSimpleResource($this->resource->photo),
            'roles' => new RoleResourceCollection($this->whenLoaded('roles')),
            'principal' => new PrincipalResource($this->resource->principal),
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
            'deleted_at' => $this->resource->deleted_at,
        ];
    }
}
