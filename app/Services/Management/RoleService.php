<?php

namespace App\Services\Management;

use App\Contracts\Abstracts\BaseService;
use App\Exceptions\RestfulApiException;
use App\Http\Requests\Management\Roles\StoreRoleRequest;
use App\Http\Requests\Management\Roles\UpdateRoleMenusRequest;
use App\Http\Requests\Management\Roles\UpdateRoleRequest;
use App\Models\Menu\RoleMenu;
use App\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class RoleService extends BaseService
{
    /**
     * @return LengthAwarePaginator
     */
    public function getAllDataPaginated(): LengthAwarePaginator
    {
        return Role::query()->paginate();
    }

    public function getDataById(Model|int|string $idOrModel): Model
    {
        /* @var Role $idOrModel */
        $idOrModel->load('menus');

        return $idOrModel;
    }

    /**
     * @param array $requestedData
     * @return Model
     * @throws RestfulApiException
     */
    public function addNewData(array $requestedData): Model
    {
        $this->validated($requestedData, new StoreRoleRequest());

        return Role::create($this->getValidatedData());
    }


    /**
     * @param int|string|Model $idOrModel
     * @param array $requestedData
     * @return int|Model
     * @throws RestfulApiException
     */
    public function updateDataById(int|string|Model $idOrModel, array $requestedData): int|Model
    {
        $this->validated($requestedData, new UpdateRoleRequest());
        $idOrModel->fill($this->getValidatedData())->save();
        return $idOrModel;
    }

    /**
     * @throws RestfulApiException
     */
    public function updateMenu(Role $role, array $requestedData): bool
    {
        $validatedData = $this->validated($requestedData, new UpdateRoleMenusRequest());

        RoleMenu::query()
            ->where('role_id', $role->id)->delete();

        $data = [];
        foreach ($validatedData as $value) {
            $data[] = [
                'id' => Str::uuid(),
                'role_id' => $role->id,
                'menu_id' => $value
            ];
        }

        return RoleMenu::query()
            ->insert($data);
    }

    /**
     * @param int|string|Model $idOrModel
     * @return int
     */
    public function deleteDataById(int|string|Model $idOrModel): int
    {
        return $idOrModel->delete();
    }
}
