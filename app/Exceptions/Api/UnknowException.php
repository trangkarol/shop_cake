<?php

namespace App\Exceptions\Api;

use Illuminate\Http\Response;
use Throwable;

class UnknowException extends BaseException
{
    public function __construct($debug = null, $code = Response::HTTP_INTERNAL_SERVER_ERROR, $table = null, $message = null, Throwable $previous)
    {
        parent::__construct($debug, $code, $table, $message, $previous);
    }
}
