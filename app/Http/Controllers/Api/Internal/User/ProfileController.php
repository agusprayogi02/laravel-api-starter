<?php

namespace App\Http\Controllers\Api\Internal\User;

use App\Exceptions\RestfulApiException;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use App\Http\Response;
use App\Services\User\ProfileService;
use Dentro\Yalr\Attributes\Get;
use Dentro\Yalr\Attributes\Name;
use Dentro\Yalr\Attributes\Prefix;
use Illuminate\Http\Request;

#[Prefix('profile')]
#[Name('profile', true, true)]
class ProfileController extends Controller
{
    protected array $responseMessages;

    public function __construct()
    {
        $this->responseMessages = [
            'index' => "Success Retrieving Data Profile",
            'menu' => "Success Retrieving Data Profile Menu",
        ];
    }

    /**
     * @param ProfileService $service
     * @return Response
     */
    #[Get('', name: 'index')]
    public function index(ProfileService $service): Response
    {
        $response = $service->getProfileData();

        return $this->response(
            new UserResource($response),
            $this->getResponseMessage(__FUNCTION__)
        );
    }

    /**
     * @param ProfileService $service
     * @return Response
     * @throws RestfulApiException
     */
    #[Get('menus', name: 'menus', middleware: ['auth:sanctum'])]
    public function menu(ProfileService $service): Response
    {
        $response = $service->getProfileMenu(
            user: auth()->user(),
        );

        return $this->response(
            $response,
            $this->getResponseMessage(__FUNCTION__)
        );
    }
}
