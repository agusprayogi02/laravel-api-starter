<?php

namespace App\Models\Geo;

use App\Enums\Table;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Veelasky\LaravelHashId\Eloquent\HashableId;

/**
 * Model Provinces
 *
 * @property string id
 * @property string name
 *
 * */
class Province extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = Table::GEO_PROVINCES->value;

    protected $fillable = [
        'country_id', 'code', 'name',
        'timezone', 'locale',
        'latitude', 'longitude', 'altitude', 'geometry',
    ];

    protected $hidden = [
        'country_id'
    ];

    //== RELATIONSHIPS

    public function province_morph(): MorphTo
    {
        return $this->morphTo();
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function cities(): HasMany
    {
        return $this->hasMany(City::class, 'province_id');
    }

    public function districts(): HasMany
    {
        return $this->hasMany(District::class, 'province_id');
    }

    public function sub_districts(): HasMany
    {
        return $this->hasMany(SubDistrict::class, 'province_id');
    }
}
