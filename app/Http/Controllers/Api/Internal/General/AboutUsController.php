<?php

namespace App\Http\Controllers\Api\Internal\General;

use App\Exceptions\RestfulApiException;
use App\Http\Controllers\Controller;
use App\Http\Resources\General\AboutUs\AboutUsResource;
use App\Http\Resources\General\AboutUs\AboutUsResourceCollection;
use App\Models\General\AboutUs;
use App\Services\General\AboutUsService;
use Dentro\Yalr\Attributes\Delete;
use Dentro\Yalr\Attributes\Get;
use Dentro\Yalr\Attributes\Middleware;
use Dentro\Yalr\Attributes\Name;
use Dentro\Yalr\Attributes\Post;
use Dentro\Yalr\Attributes\Prefix;
use Dentro\Yalr\Attributes\Put;
use Illuminate\Http\Request;

#[Prefix('about-us')]
#[Name('about-us', true, true)]
#[Middleware(['auth:sanctum'])]
class AboutUsController extends Controller
{
    protected array $responseMessages;

    public function __construct()
    {
        $this->responseMessages = [
            'index' => 'Success Retrieving Data About Us',
            'store' => 'Success Create Data About Us',
            'show' => 'Success Retrieving Data About Us',
            'update' => 'Success Update Data About Us',
            'delete' => 'Success Delete Data About Us',
        ];
    }

    /**
     * @throws RestfulApiException
     */
    #[Get('', name: 'index')]
    public function index(AboutUsService $service)
    {
        $response = $service->getAllDataPaginated();

        return $this->response(
            new AboutUsResourceCollection($response),
            $this->getResponseMessage(__FUNCTION__)
        );
    }

    #[Get('{aboutUs}', name: 'show')]
    public function show(AboutUs $aboutUs)
    {
        return $this->response(
            new AboutUsResource($aboutUs),
            $this->getResponseMessage(__FUNCTION__)
        );
    }

    /**
     * @throws RestfulApiException
     */
    #[Post('', name: 'store')]
    public function store(Request $request, AboutUsService $service)
    {
        $response = $service->addNewData(
            requestedData: $request->post(),
        );

        return $this->response(
            new AboutUsResource($response),
            $this->getResponseMessage(__FUNCTION__)
        );
    }

    /**
     * @throws RestfulApiException
     */
    #[Put('{aboutUs}', name: 'update')]
    public function update(AboutUs $aboutUs, Request $request, AboutUsService $service)
    {
        $service->updateDataById(
            idOrModel: $aboutUs,
            requestedData: $request->post(),
        );

        return $this->response(
            null,
            $this->getResponseMessage(__FUNCTION__)
        );
    }

    #[Delete('{aboutUs}', name: 'delete')]
    public function delete(AboutUs $aboutUs)
    {
        $aboutUs->delete();

        return $this->response(
            null,
            $this->getResponseMessage(__FUNCTION__)
        );
    }
}
