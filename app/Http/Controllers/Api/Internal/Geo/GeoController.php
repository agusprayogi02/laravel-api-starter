<?php

namespace App\Http\Controllers\Api\Internal\Geo;

use App\Http\Controllers\Controller;
use App\Http\Response;
use App\Models\Geo\City;
use App\Models\Geo\Country;
use App\Models\Geo\District;
use App\Models\Geo\Province;
use App\Services\Geo\GeoService;
use Dentro\Yalr\Attributes\Get;
use Dentro\Yalr\Attributes\Middleware;
use Dentro\Yalr\Attributes\Name;
use Dentro\Yalr\Attributes\Prefix;
use Illuminate\Http\Request;

#[Prefix('geo')]
#[Name('geo', true, true)]
class GeoController extends Controller
{
    protected array $responseMessages;

    public function __construct()
    {
        $this->responseMessages = [
            'countries' => 'Success Retrieving Data Country',
            'provinces' => 'Success Retrieving Data Province',
            'cities' => 'Success Retrieving Data City',
            'districts' => 'Success Retrieving Data District',
            'subDistricts' => 'Success Retrieving Data Sub District',
        ];
    }

    #[Get('countries', name: 'countries')]
    public function countries(GeoService $service): Response
    {
        $response = $service->getAllCountry();

        return $this->response(
            $response,
            $this->getResponseMessage(__FUNCTION__)
        );
    }

    #[Get('provinces', name: 'provinces')]
    public function provinces(GeoService $service): Response
    {
        $response = $service->getAllProvince();

        return $this->response(
            $response,
            $this->getResponseMessage(__FUNCTION__)
        );
    }

    #[Get('cities/{province}', name: 'cities')]
    public function cities(Province $province, GeoService $service): Response
    {
        $response = $service->getAllCity($province->id);

        return $this->response(
            $response,
            $this->getResponseMessage(__FUNCTION__)
        );
    }

    #[Get('districts/{city}', name: 'districts')]
    public function districts(City $city, GeoService $service): Response
    {
        $response = $service->getAllDistrict($city->id);

        return $this->response(
            $response,
            $this->getResponseMessage(__FUNCTION__)
        );
    }

    #[Get('sub-districts/{district}', name: 'districts')]
    public function subDistricts(District $district, GeoService $service): Response
    {
        $response = $service->getAllSubDistrict($district->id);

        return $this->response(
            $response,
            $this->getResponseMessage(__FUNCTION__)
        );
    }
}
