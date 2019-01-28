<?php

namespace App\Exceptions\Api;

use Illuminate\Http\Response;
use Throwable;

class NotFoundException extends BaseException
{
    public function __construct($debug = null, $code = Response::HTTP_NOT_FOUND, $table = null, $message = null,  Throwable $previous)
    {
        parent::__construct($debug, $code, $table, $message, $previous);
    }
}
