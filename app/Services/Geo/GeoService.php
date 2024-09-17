<?php

namespace App\Services\Geo;

use App\Contracts\Abstracts\BaseService;
use App\Models\Geo\City;
use App\Models\Geo\Country;
use App\Models\Geo\District;
use App\Models\Geo\Province;
use App\Models\Geo\SubDistrict;
use Illuminate\Database\Eloquent\Collection;

class GeoService extends BaseService
{
    public function getAllCountry(): Collection
    {
        return Country::query()
            ->orderBy('name')
            ->get();
    }

    public function getAllProvince(): Collection
    {
        return Province::query()
            ->orderBy('name')
            ->get();
    }

    public function getAllCity($provinceId): Collection
    {
        return City::query()
            ->where('province_id', $provinceId)
            ->orderBy('name')
            ->get();
    }

    public function getAllDistrict($cityId): Collection
    {
        return District::query()
            ->where('city_id', $cityId)
            ->orderBy('name')
            ->get();
    }

    public function getAllSubDistrict($districtId): Collection
    {
        return SubDistrict::query()
            ->where('district_id', $districtId)
            ->orderBy('name')
            ->get();
    }
}
