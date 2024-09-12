<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class ApiDumpException extends Exception
{
    public function __construct(public mixed $data)
    {
    }

    #Post
    public function render(): JsonResponse
    {
        return response()->json([$this->data]);
    }
}
