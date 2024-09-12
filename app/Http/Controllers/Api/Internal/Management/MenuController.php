<?php

namespace App\Http\Controllers\Api\Internal\Management;

use App\Exceptions\RestfulApiException;
use App\Http\Controllers\Controller;
use App\Services\Management\MenuService;
use Dentro\Yalr\Attributes\Get;
use Dentro\Yalr\Attributes\Middleware;
use Dentro\Yalr\Attributes\Name;
use Dentro\Yalr\Attributes\Prefix;

#[Prefix('management/menus')]
#[Name('management.menus', true, true)]
#[Middleware('auth:sanctum')]
class MenuController extends Controller
{
    protected array $responseMessages;

    public function __construct()
    {
        $this->responseMessages = [
            '__invoke' => 'Success Retrieving Data Menu',
        ];
    }

    /**
     * @throws RestfulApiException
     */
    #[Get('', name: 'index')]
    public function __invoke(MenuService $service)
    {
        $response = $service->getAllMenu();

        return $this->response(
            $response,
            $this->getResponseMessage(__FUNCTION__)
        );
    }
}
