<?php

namespace App\Models\Geo;

use App\Enums\Table;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Model Address
 *
 * @property string $id
 * @property string $ownerable_type
 * @property string $ownerable_id
 * @property string $province_id
 * @property string $city_id
 * @property string $district_id
 * @property string $complete_address
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Province $province
 * @property City $city
 * @property District $district
 * @property SubDistrict $subDistrict
 */
class Address extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = Table::ADDRESS->value;

    protected $fillable = [
        'ownerable_type', 'ownerable_id', 'province_id', 'city_id', 'district_id', 'sub_district_id', 'complete_address'
    ];

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function subDistrict(): BelongsTo
    {
        return $this->belongsTo(SubDistrict::class);
    }

    public function ownerable(): MorphTo
    {
        return $this->morphTo();
    }
}
