<?php

namespace App\Http\Controllers\Api\Internal\Auth;

use App\Enums\ResponseCode;
use App\Exceptions\RestfulApiException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthenticateRequest;
use App\Http\Resources\Auth\AuthResource;
use App\Http\Response;
use App\Services\Auth\AuthService;
use Dentro\Yalr\Attributes\Get;
use Dentro\Yalr\Attributes\Name;
use Dentro\Yalr\Attributes\Post;
use Dentro\Yalr\Attributes\Prefix;

#[Prefix('')]
#[Name('', false, true)]
class AuthController extends Controller
{
    protected array $responseMessages;

    public function __construct()
    {
        $this->responseMessages = [
            'authenticate' => 'Login user successfully',
            'login' => 'Tolong Login, dengan metode Get!',
        ];
    }

    /**
     * @throws RestfulApiException
     */
    #[Post('', name: 'authenticate')]
    public function authenticate(AuthService $service, AuthenticateRequest $request): Response
    {
        $response = $service->authenticate($request->validated());

        return $this->response(
            new AuthResource($response),
            $this->getResponseMessage(__FUNCTION__)
        );
    }

    /**
     * @throws RestfulApiException
     */
    #[Get('', name: 'login')]
    public function login()
    {
        throw new RestfulApiException(ResponseCode::ERR_AUTHENTICATION, 'Tolong Login, dengan metode Post!');
    }

    #[Post('/logout', name: 'logout')]
    public function logout(AuthService $service)
    {
        $service->logout();

        return $this->response(null, $this->getResponseMessage(__FUNCTION__));
    }
}
