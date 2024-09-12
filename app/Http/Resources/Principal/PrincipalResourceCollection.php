<?php

namespace App\Http\Resources\Principal;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PrincipalResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
