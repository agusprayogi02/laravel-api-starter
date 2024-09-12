<?php

namespace App\Contracts\Abstracts;

use App\Contracts\Interfaces\BaseServiceInterface;
use App\Enums\ResponseCode;
use App\Exceptions\RestfulApiException;
use App\Traits\ValidationInput;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class BaseService implements BaseServiceInterface
{
    use ValidationInput;


    /**
     * @throws RestfulApiException
     */
    public function getAllDataPaginated(): LengthAwarePaginator
    {
        throw new RestfulApiException(ResponseCode::ERR_METHOD_NOT_IMPLEMENTED);
    }

    /**
     * @throws RestfulApiException
     */
    public function getAllData(): Collection
    {
        throw new RestfulApiException(ResponseCode::ERR_METHOD_NOT_IMPLEMENTED);

    }

    /**
     * @throws RestfulApiException
     */
    public function getDataById(Model|int|string $idOrModel): Model
    {
        throw new RestfulApiException(ResponseCode::ERR_METHOD_NOT_IMPLEMENTED);

    }

//    /**
//     * @throws MaasyaException
//     */
//    public function addNewData(array $requestedData): int|Model
//    {
//        throw new MaasyaException(ResponseCode::ERR_METHOD_NOT_IMPLEMENTED);
//    }

    /**
     * @throws RestfulApiException
     */
    public function updateDataById(Model|int|string $idOrModel, array $requestedData): int|Model
    {
        throw new RestfulApiException(ResponseCode::ERR_METHOD_NOT_IMPLEMENTED);
    }

    /**
     * @throws RestfulApiException
     */
    public function deleteDataById(Model|int|string $idOrModel): int
    {
        throw new RestfulApiException(ResponseCode::ERR_METHOD_NOT_IMPLEMENTED);
    }
}
