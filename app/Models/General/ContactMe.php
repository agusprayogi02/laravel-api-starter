<?php

namespace App\Models\General;

use App\Enums\Table;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Model Banner
 *
 * @property string $id
 * @property string $name
 * @property string $email
 * @property string $message
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 *
 * */
class ContactMe extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = Table::CONTACT_ME->value;

    protected $fillable = ['name', 'email', 'message', 'created_at', 'updated_at', 'deleted_at'];
}
