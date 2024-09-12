<?php

namespace App\Models\Geo;

use App\Enums\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Veelasky\LaravelHashId\Eloquent\HashableId;

class District extends Model
{
    use HashableId, SoftDeletes;

    protected $table = Table::GEO_DISTRICTS->value;

    protected $fillable = [
        'country_id', 'province_id', 'city_id',
        'code', 'name',
        'timezone', 'locale',
        'latitude', 'longitude', 'altitude', 'geometry',
    ];

    protected $appends = ['hash'];

    //== RELATIONSHIPS

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function sub_districts(): HasMany
    {
        return $this->hasMany(SubDistrict::class, 'district_id');
    }
}
