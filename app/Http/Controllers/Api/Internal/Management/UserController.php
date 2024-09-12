<?php

namespace App\Http\Controllers\Api\Internal\Management;

use App\Exceptions\RestfulApiException;
use App\Http\Controllers\Controller;
use App\Http\Resources\Management\Users\UserResource;
use App\Http\Response;
use App\Models\User;
use App\Services\Management\UserService;
use Dentro\Yalr\Attributes\Middleware;
use Dentro\Yalr\Attributes\Name;
use Dentro\Yalr\Attributes\Prefix;
use Dentro\Yalr\Attributes\Put;
use Illuminate\Http\Request;

#[Prefix('management/users')]
#[Name('management.users', true, true)]
#[Middleware(['auth:sanctum'])]
class UserController extends Controller
{
    protected array $responseMessages;

    public function __construct()
    {
        $this->responseMessages = [
            "syncUserRole" => "Sync user role by id successfully",
        ];
    }

    /**
     * @param User $user
     * @param Request $request
     * @param UserService $service
     * @return Response
     * @throws RestfulApiException
     */
    #[Put('/{user}/sync-user-roles', name: 'sync.user.roles')]
    public function syncUserRole(User $user, Request $request, UserService $service): Response
    {
        $response = $service->syncUserRole(
            user: $user,
            requestedData: $request->post(),
        );

        return $this->response(
            new UserResource($response),
            $this->getResponseMessage(__FUNCTION__)
        );
    }
}
