<?php

namespace Database\Seeders\Geo;

use App\Models\Geo\City;
use App\Models\Geo\Country;
use App\Models\Geo\District;
use App\Models\Geo\Province;
use App\Models\Geo\SubDistrict;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class GeoSeeder extends Seeder
{
    private static Collection $countries;
    private static Collection $provinces;
    private static Collection $cities;
    private static Collection $districts;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        self::$countries = collect();
        self::$provinces = collect();
        self::$cities = collect();
        self::$districts = collect();

        $this->command->info('   Seeding Countries');
        $this->seedingCountry();

        $this->command->newLine();
        $this->command->info('   Seeding Provinces');
        $this->seedingProvinces();

        $this->command->newLine();
        $this->command->info('   Seeding Cities');
        $this->seedingCities();

        $this->command->newLine();
        $this->command->info('   Seeding Districts');
        $this->seedingDistricts();

        $this->command->newLine();
        $this->command->info('   Seeding Sub Districts');
        $this->seedingSubDistricts();

        $this->command->newLine();
    }

    private function seedingCountry(): void
    {
        $totalRows = 241;

        if (($open = fopen(database_path("data/geo_countries.csv"), "r")) !== false) {
            $this->command->withProgressBar($totalRows, function ($bar) use ($open) {
                $bar->setFormat("   %percent:3s%% [%bar%] %current%/%max% in %elapsed:6s%");

                $countries = [];
                while (($row = fgetcsv($open, separator: ",")) !== false) {
                    if ($row[2] !== 'ISO3') {
                        $now = now();
                        $countries[] = [
                            'iso_3' => "{$row[2]}",
                            'iso_2' => "{$row[1]}",
                            'iso_number' => "{$row[5]}",
                            'fips' => "{$row[4]}",
                            'phone_code' => "{$row[8]}",
                            'phone_code_e164' => "{$row[7]}",
                            'name' => "{$row[0]}",
                            'currency' => "{$row[12]}",
                            'continent' => "{$row[9]}",
                            'timezone' => "{$row[11]}",
                            'locale' => "{$row[13]}",
                            'created_at' => $now,
                            'updated_at' => $now,
                        ];
                    }

                    if (count($countries) === 100) {
                        Country::query()->insert($countries);
                        $countries = [];
                    }

                    $bar->advance();
                }

                if (count($countries) > 0 && count($countries) < 100) {
                    Country::query()->insert($countries);
                }
            });

            fclose($open);
        }
    }

    private function seedingProvinces(): void
    {
        $totalRows = 35;

        if (($open = fopen(database_path("data/geo_provinces.csv"), "r")) !== false) {
            $country = Country::query()->where('iso_3', 'IDN')->first();

            if ($country instanceof Country) {
                $this->command->withProgressBar($totalRows, function ($bar) use ($open, $country) {
                    $bar->setFormat("   %percent:3s%% [%bar%] %current%/%max% in %elapsed:6s%");

                    $provinces = [];
                    while (($row = fgetcsv($open, separator: ",")) !== false) {
                        if ($row[0] != 'id') {
                            $now = now();
                            $provinces[] = [
                                'code' => "{$row[0]}",
                                'country_id' => $country->id,
                                'name' => "{$row[1]}",
                                'created_at' => $now,
                                'updated_at' => $now,
                            ];
                        }

                        if (count($provinces) == 100) {
                            Province::query()->insert($provinces);
                            $provinces = [];
                        }

                        $bar->advance();
                    }

                    if (count($provinces) > 0 && count($provinces) < 100) {
                        Province::query()->insert($provinces);
                    }
                });
            }

            fclose($open);
        }
    }

    private function seedingCities(): void
    {
        $totalRows = 515;
        self::$provinces = Province::query()->get()->keyBy('code');

        if (($open = fopen(database_path("data/geo_cities.csv"), "r")) !== false) {
            $this->command->withProgressBar($totalRows, function ($bar) use ($open) {
                $bar->setFormat("   %percent:3s%% [%bar%] %current%/%max% in %elapsed:6s%");

                $cities = [];
                while (($row = fgetcsv($open, separator: ",")) !== false) {
                    if ($row[0] != 'id') {
                        $province = self::$provinces->get($row[1]);

                        if ($province instanceof Province) {
                            $now = now();
                            $cities[] = [
                                'code' => "{$row[0]}",
                                'country_id' => $province->country_id,
                                'province_id' => $province->id,
                                'name' => "{$row[2]}",
                                'created_at' => $now,
                                'updated_at' => $now,
                            ];
                        }
                    }

                    if (count($cities) == 100) {
                        City::query()->insert($cities);
                        $cities = [];
                    }

                    $bar->advance();
                }

                if (count($cities) > 0 && count($cities) < 100) {
                    City::query()->insert($cities);
                }
            });

            fclose($open);
        }
    }

    private function seedingDistricts(): void
    {
        $totalRows = 7202;
        self::$cities = City::query()->get()->keyBy('code');

        if (($open = fopen(database_path("data/geo_districts.csv"), "r")) !== false) {
            $this->command->withProgressBar($totalRows, function ($bar) use ($open) {
                $bar->setFormat("   %percent:3s%% [%bar%] %current%/%max% in %elapsed:6s%");

                $districts = [];
                while (($row = fgetcsv($open, separator: ",")) !== false) {
                    if ($row[0] != 'id') {
                        $city = self::$cities->get($row[2]);

                        if ($city instanceof City) {
                            $now = now();
                            $districts[] = [
                                'code' => "{$row[0]}",
                                'country_id' => $city->country_id,
                                'province_id' => $city->province_id,
                                'city_id' => $city->id,
                                'name' => "{$row[3]}",
                                'created_at' => $now,
                                'updated_at' => $now,
                            ];
                        }
                    }

                    if (count($districts) == 100) {
                        District::query()->insert($districts);
                        $districts = [];
                    }

                    $bar->advance();
                }

                if (count($districts) > 0 && count($districts) < 100) {
                    District::query()->insert($districts);
                }
            });

            fclose($open);
        }
    }

    private function seedingSubDistricts(): void
    {
        $totalRows = 83437;
        self::$districts = District::query()->get()->keyBy('code');

        if (($open = fopen(database_path("data/geo_sub_districts.csv"), "r")) !== false) {
            $this->command->withProgressBar($totalRows, function ($bar) use ($open) {
                $bar->setFormat("   %percent:3s%% [%bar%] %current%/%max% in %elapsed:6s%");

                $subDistricts = [];
                while (($row = fgetcsv($open, separator: ",")) !== false) {
                    if ($row[0] != 'id') {
                        $district = self::$districts->get($row[3]);

                        if ($district instanceof District) {
                            $now = now();
                            $subDistricts[] = [
                                'country_id' => $district->country_id,
                                'province_id' => $district->province_id,
                                'city_id' => $district->city_id,
                                'district_id' => $district->id,
                                'code' => "{$row[0]}",
                                'name' => "{$row[4]}",
                                'postal_code' => "{$row[5]}",
                                'created_at' => $now,
                                'updated_at' => $now,
                            ];
                        }
                    }

                    if (count($subDistricts) == 100) {
                        SubDistrict::query()->insert($subDistricts);
                        $subDistricts = [];
                    }

                    $bar->advance();
                }

                if (count($subDistricts) > 0 && count($subDistricts) < 100) {
                    SubDistrict::query()->insert($subDistricts);
                }
            });

            fclose($open);
        }
    }
}
