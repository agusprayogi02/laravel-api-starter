<?php

namespace App\Services\Management;

use App\Contracts\Abstracts\BaseService;
use App\Exceptions\RestfulApiException;
use App\Repositories\MenuRepository;

class MenuService extends BaseService
{

    protected MenuRepository $repository;

    public function __construct(MenuRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @throws RestfulApiException
     */
    public function getAllMenu(): array
    {
        return $this->repository->getAllMenu();
    }
}
