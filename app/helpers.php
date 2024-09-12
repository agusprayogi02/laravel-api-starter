<?php

use App\Exceptions\ApiDumpException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;

/**
 * @throws ApiDumpException
 */
function ddapi(mixed $data)
{
    throw new ApiDumpException($data);
}

function getRawSql($query): string
{
    if ($query instanceof \Illuminate\Database\Query\Builder || $query instanceof Builder) {
        return Str::replaceArray(
            '?',
            array_map(fn($b) => is_string($b) ? DB::connection()->getPdo()->quote($b) : $b, $query->getBindings()),
            $query->toSql()
        );
    }
    return '$query must be instance of Query\Builder or Eloquent\Builder';
}
