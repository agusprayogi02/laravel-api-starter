<?php

namespace App\Services\General;

use App\Contracts\Abstracts\BaseService;
use App\Http\Requests\General\AboutUs\StoreAboutUsRequest;
use App\Http\Requests\General\AboutUs\UpdateAboutUsRequest;
use App\Models\General\AboutUs;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class AboutUsService extends BaseService
{
    public function getAllDataPaginated(): LengthAwarePaginator
    {
        return QueryBuilder::for(AboutUs::class)
            ->allowedSorts('title', 'order', 'is_active')
            ->allowedFilters([
                AllowedFilter::exact('is_active')
            ])
            ->pagination();
    }

    public function addNewData(array $requestedData): int|Model
    {
        $validatedData = $this->validated($requestedData, new StoreAboutUsRequest());

        return AboutUs::query()
            ->create($validatedData);
    }

    public function updateDataById(Model|int|string $idOrModel, array $requestedData): int|Model
    {
        /* @var AboutUs $idOrModel */

        $requestedData['id'] = $idOrModel->id;
        $validatedData = $this->validated($requestedData, new UpdateAboutUsRequest([], $requestedData));

        return $idOrModel->fill($validatedData)->save();
    }
}
