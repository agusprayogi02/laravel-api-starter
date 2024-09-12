<?php

namespace App\Vendors\Sanctum;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

class PersonalAccessToken extends \Laravel\Sanctum\PersonalAccessToken
{
    use HasUuids;
}
