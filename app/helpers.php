<?php

use App\Exceptions\ApiDumpException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;

/**
 * @throws ApiDumpException
 */
if (!function_exists('ddapi')) {
    function ddapi(mixed $data)
    {
        throw new ApiDumpException($data);
    }
}

if (!function_exists('getRawSql')) {
    function getRawSql($query): string
    {
        if ($query instanceof QueryBuilder || $query instanceof Builder) {
            return Str::replaceArray(
                '?',
                array_map(fn($b) => is_string($b) ? DB::connection()->getPdo()->quote($b) : $b, $query->getBindings()),
                $query->toSql()
            );
        }
        return '$query must be instance of Query\Builder or Eloquent\Builder';
    }
}
