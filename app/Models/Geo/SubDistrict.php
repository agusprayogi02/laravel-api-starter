<?php

namespace App\Models\Geo;

use App\Enums\Table;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Model SubDistrict
 *
 * @property integer $id
 * @property string $name
 */
class SubDistrict extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = Table::GEO_SUB_DISTRICTS->value;

    protected $fillable = [
        'country_id', 'province_id', 'city_id', 'district_id',
        'code', 'name', 'postal_code',
        'timezone', 'locale',
        'latitude', 'longitude', 'altitude', 'geometry',
    ];

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

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class, 'district_id');
    }
}
