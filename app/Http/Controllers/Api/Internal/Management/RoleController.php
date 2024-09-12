<?php

namespace App\Http\Controllers\Api\Internal\Management;

use App\Exceptions\RestfulApiException;
use App\Http\Controllers\Controller;
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
use Illuminate\Http\Request;

#[Prefix('management/roles')]
#[Name('management.roles', true, true)]
class RoleController extends Controller
{
    protected array $responseMessages;

    public function __construct()
    {
        $this->responseMessages = [
            "index" => "Get all data role paginated successfully",
            "show" => "Get data role by id successfully",
            "store" => "Add new data role successfully",
            "update" => "Update data role by id successfully",
            "updateMenu" => "Update data role menu by id successfully",
            "destroy" => "Delete data role by id successfully",
        ];
    }

    /**
     * @param RoleService $service
     * @return Response
     */
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
    public function updateMenu(Role $role, Request $request, RoleService $service)
    {
        $service->updateMenu(
            role: $role,
            requestedData: $request->post()
        );

        return $this->response(
            null,
            $this->getResponseMessage(__FUNCTION__)
        );
    }

    /**
     * @param RoleService $service
     * @param Request $request
     * @return Response
     * @throws RestfulApiException
     */
    #[Post('/', name: 'store')]
    public function store(RoleService $service, Request $request): Response
    {
        $response = $service->addNewData($request->post());
        return $this->response(
            new RoleResource($response),
            $this->getResponseMessage(__FUNCTION__)
        );
    }


    /**
     * @param Role $role
     * @param Request $request
     * @param RoleService $service
     * @return Response
     * @throws RestfulApiException
     */
    #[Patch('/{role}', name: 'update')]
    public function update(Role $role, Request $request, RoleService $service): Response
    {
        $response = $service->updateDataById($role, $request->post());
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
