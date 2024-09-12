<?php

namespace App\Http\Resources\CustomBond;

use App\Http\Resources\General\BranchOffice\BranchOfficeResource;
use App\Http\Resources\General\BranchOffice\BranchOfficeSimpleResource;
use App\Http\Resources\General\Obligee\ObligeeResource;
use App\Http\Resources\General\Obligee\ObligeeSimpleResource;
use App\Http\Resources\General\Product\ProductSimpleResource;
use App\Http\Resources\General\Product\ProductSimpleResourceCollection;
use App\Models\CustomBond;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property CustomBond $resource
 * */
class CustomBondResource extends JsonResource
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
            'registration_number' => $this->resource->registration_number,
            'start_date' => $this->resource->start_date,
            'end_date' => $this->resource->end_date,
            'status' => $this->resource->status,
            'guarantee_amount' => $this->resource->guarantee_amount,
            'rate' => $this->resource->rate,
            'total_amount' => $this->resource->total_amount,
            'skep_number' => $this->resource->skep_number,
            'skep_date' => $this->resource->skep_date,
            'pib_number' => $this->resource->pib_number,
            'pib_date' => $this->resource->pib_date,
            'sub_contract_number' => $this->resource->sub_contract_number,
            'sub_contract_date' => $this->resource->sub_contract_date,
            'kepabeanan_description' => $this->resource->kepabeanan_description,
            'activity_description' => $this->resource->activity_description,
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
            'obligee' => new ObligeeSimpleResource($this->whenLoaded('obligee')),
            'product' => new ProductSimpleResource($this->whenLoaded('product')),
            'branch_office' => new BranchOfficeSimpleResource($this->whenLoaded('branch_office')),
        ];
    }
}
