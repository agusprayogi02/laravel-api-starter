<?php

namespace App\Http\Controllers\Api\Internal\General;

use App\Exceptions\RestfulApiException;
use App\Http\Controllers\Controller;
use App\Http\Resources\General\ContactMe\ContactMeResource;
use App\Http\Resources\General\ContactMe\ContactMeResourceCollection;
use App\Models\General\ContactMe;
use App\Services\General\ContactMeService;
use Dentro\Yalr\Attributes\Delete;
use Dentro\Yalr\Attributes\Get;
use Dentro\Yalr\Attributes\Middleware;
use Dentro\Yalr\Attributes\Name;
use Dentro\Yalr\Attributes\Post;
use Dentro\Yalr\Attributes\Prefix;
use Illuminate\Http\Request;

#[Prefix('contact-me')]
#[Name('contact-me', true, true)]
#[Middleware(['auth:sanctum'])]
class ContactMeController extends Controller
{
    protected array $responseMessages;

    public function __construct()
    {
        $this->responseMessages = [
            'index' => 'Success Retrieving Data Contact Me',
            'store' => 'Success Create Data Contact Me',
            'show' => 'Success Retrieving Data Contact Me',
            'delete' => 'Success Delete Data Contact Me',
        ];
    }

    /**
     * @throws RestfulApiException
     */
    #[Get('', name: 'index')]
    public function index(ContactMeService $service)
    {
        $response = $service->getAllDataPaginated();

        return $this->response(
            new ContactMeResourceCollection($response),
            $this->getResponseMessage(__FUNCTION__)
        );
    }

    #[Get('{contactMe}', name: 'show')]
    public function show(ContactMe $contactMe)
    {
        return $this->response(
            new ContactMeResource($contactMe),
            $this->getResponseMessage(__FUNCTION__)
        );
    }

    /**
     * @throws RestfulApiException
     */
    #[Post('', name: 'store')]
    public function store(Request $request, ContactMeService $service)
    {
        $response = $service->addNewData(
            requestedData: $request->post(),
        );

        return $this->response(
            new ContactMeResource($response),
            $this->getResponseMessage(__FUNCTION__)
        );
    }

    #[Delete('{contactMe}', name: 'delete')]
    public function delete(ContactMe $contactMe)
    {
        $contactMe->delete();

        return $this->response(
            null,
            $this->getResponseMessage(__FUNCTION__)
        );
    }
}
