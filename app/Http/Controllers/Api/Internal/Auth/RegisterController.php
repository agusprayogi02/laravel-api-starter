<?php

namespace App\Http\Controllers\Api\Internal\Auth;

use App\Exceptions\RestfulApiException;
use App\Http\Controllers\Controller;
use App\Services\Auth\RegisterService;
use Dentro\Yalr\Attributes\Name;
use Dentro\Yalr\Attributes\Post;
use Dentro\Yalr\Attributes\Prefix;
use Illuminate\Http\Request;

#[Prefix('register')]
#[Name('register', false, true)]
class RegisterController extends Controller
{
    protected array $responseMessages;

    public function __construct()
    {
        $this->responseMessages = [
            '__invoke' => "Register successfully",
        ];
    }

    /**
     * @throws RestfulApiException
     */
    #[Post('', name: '')]
    public function __invoke(Request $request, RegisterService $service)
    {
        $service->registration(
            requestedData: $request->post()
        );

        return $this->response(
            null,
            $this->getResponseMessage(__FUNCTION__)
        );
    }
}
