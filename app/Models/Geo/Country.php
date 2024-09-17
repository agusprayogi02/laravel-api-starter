<?php

namespace App\Models\Geo;

use App\Enums\Table;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Veelasky\LaravelHashId\Eloquent\HashableId;

/**
 * Country Model
 *
 * @property int $id
 *
 * */
class Country extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = Table::GEO_COUNTRIES->value;

    protected $fillable = [
        'iso_2', 'iso_3', 'iso_number', 'fips',
        'phone_code', 'phone_code_e164',
        'name', 'continent', 'currency', 'currency_code',
        'timezone', 'locale',
        'latitude', 'longitude', 'altitude', 'geometry',
    ];

    //== RELATIONSHIPS

    public function country_morph(): MorphTo
    {
        return $this->morphTo();
    }

    public function provinces(): HasMany
    {
        return $this->hasMany(Province::class, 'country_id');
    }

    public function cities(): HasMany
    {
        return $this->hasMany(City::class, 'country_id');
    }

    public function districts(): HasMany
    {
        return $this->hasMany(District::class, 'country_id');
    }

    public function sub_districts(): HasMany
    {
        return $this->hasMany(SubDistrict::class, 'country_id');
    }
}
