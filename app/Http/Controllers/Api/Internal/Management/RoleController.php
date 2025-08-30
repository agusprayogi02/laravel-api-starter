<?php

namespace App\Http\Controllers\Api\Internal\Management;

use App\Exceptions\RestfulApiException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Management\Roles\StoreRoleRequest;
use App\Http\Requests\Management\Roles\UpdateRoleMenusRequest;
use App\Http\Requests\Management\Roles\UpdateRoleRequest;
use App\Http\Resources\Management\Roles\RoleResource;
use App\Http\Resources\Management\Roles\RoleResourceCollection;
use App\Http\Response;
use App\Models\Role;
use App\Services\Management\RoleService;
use Dentro\Yalr\Attributes\Delete;
use Dentro\Yalr\Attributes\Get;
use Dentro\Yalr\Attributes\Name;
use Dentro\Yalr\Attributes\Patch;
use Dentro\Yalr\Attributes\Post;
use Dentro\Yalr\Attributes\Prefix;
use Dentro\Yalr\Attributes\Put;

#[Prefix('management/roles')]
#[Name('management.roles', true, true)]
class RoleController extends Controller
{
    protected array $responseMessages;

    public function __construct()
    {
        $this->responseMessages = [
            'index' => 'Get all data role paginated successfully',
            'show' => 'Get data role by id successfully',
            'store' => 'Add new data role successfully',
            'update' => 'Update data role by id successfully',
            'updateMenu' => 'Update data role menu by id successfully',
            'destroy' => 'Delete data role by id successfully',
        ];
    }

    #[Get('', name: 'index')]
    public function index(RoleService $service): Response
    {
        $response = $service->getAllDataPaginated();

        return $this->response(
            new RoleResourceCollection($response),
            $this->getResponseMessage(__FUNCTION__)
        );
    }

    /**
     * @throws RestfulApiException
     */
    #[Get('/{role}', name: 'show')]
    public function show(Role $role, RoleService $service): Response
    {
        $response = $service->getDataById(
            idOrModel: $role
        );

        return $this->response(
            new RoleResource($response),
            $this->getResponseMessage(__FUNCTION__)
        );
    }

    /**
     * @throws RestfulApiException
     */
    #[Put('{role}/menus', name: 'update-menu')]
    public function updateMenu(Role $role, UpdateRoleMenusRequest $request, RoleService $service)
    {
        $service->updateMenu(
            role: $role,
            requestedData: $request->validated()
        );

        return $this->response(
            null,
            $this->getResponseMessage(__FUNCTION__)
        );
    }

    /**
     * @throws RestfulApiException
     */
    #[Post('/', name: 'store')]
    public function store(RoleService $service, StoreRoleRequest $request): Response
    {
        $response = $service->addNewData($request->validated());

        return $this->response(
            new RoleResource($response),
            $this->getResponseMessage(__FUNCTION__)
        );
    }

    /**
     * @throws RestfulApiException
     */
    #[Patch('/{role}', name: 'update')]
    public function update(Role $role, UpdateRoleRequest $request, RoleService $service): Response
    {
        $response = $service->updateDataById($role, $request->validated());

        return $this->response(
            new RoleResource($response),
            $this->getResponseMessage(__FUNCTION__)
        );
    }

    #[Delete('/{role}', name: 'destroy')]
    public function destroy(Role $role, RoleService $service): Response
    {
        $service->deleteDataById($role);

        return $this->response(
            null,
            $this->getResponseMessage(__FUNCTION__)
        );
    }
}
