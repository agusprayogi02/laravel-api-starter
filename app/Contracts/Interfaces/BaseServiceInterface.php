<?php

namespace App\Contracts\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface BaseServiceInterface
{

    public function getAllDataPaginated(): LengthAwarePaginator;

    public function getAllData(): Collection;

    public function getDataById(int|string|Model $idOrModel): Model;

//    public function addNewData(array $requestedData): int|Model;

    public function updateDataById(int|string|Model $idOrModel, array $requestedData): int|Model;

    public function deleteDataById(int|string|Model $idOrModel): int;
}
