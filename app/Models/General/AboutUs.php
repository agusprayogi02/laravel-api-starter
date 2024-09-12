<?php

namespace App\Models\General;

use App\Enums\Table;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * Model About Us
 *
 * @property string $id
 * @property string $title
 * @property string $description
 * @property int $order
 * @property bool $is_active
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 *
 * */
class AboutUs extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = Table::ABOUT_US->value;

    protected $fillable = ['title', 'description', 'order', 'is_active', 'created_at', 'updated_at'];

    protected $casts = [
        'order' => 'integer',
        'is_active' => 'bool'
    ];
}
