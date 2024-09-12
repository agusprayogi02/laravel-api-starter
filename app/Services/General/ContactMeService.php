<?php

namespace App\Services\General;

use App\Contracts\Abstracts\BaseService;
use App\Http\Requests\General\ContactMe\StoreContactMeRequest;
use App\Models\General\ContactMe;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\QueryBuilder;

class ContactMeService extends BaseService
{
    public function getAllDataPaginated(): LengthAwarePaginator
    {
        return QueryBuilder::for(ContactMe::class)
            ->allowedSorts('name', 'email', 'created_at')
            ->pagination();
    }

    public function addNewData(array $requestedData): int|Model
    {
        $validatedData = $this->validated($requestedData, new StoreContactMeRequest());

        return ContactMe::query()
            ->create($validatedData);
    }
}
