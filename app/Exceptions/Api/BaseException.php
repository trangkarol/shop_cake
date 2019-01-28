<?php

namespace App\Exceptions\Api;

use Exception;
use Illuminate\Http\Response;
use Throwable;

abstract class BaseException extends Exception
{
    protected $code = null;
    protected $debug = null;

    public function __construct($debug = null, $code = null, $table = null, $message = null, Throwable $previous = null)
    {
        if (!$code || !is_numeric($code) || $code < 100 || $code >= 600) {
            $code = Response::HTTP_BAD_REQUEST;
        }

        if (!$message) {
            $message = $code == Response::HTTP_BAD_REQUEST ? trans("message.{$code}.{$table}") : trans('status_code.' . $code);
        }

        $this->code = $code;
        $this->message = $message;
        $this->debug = $debug;

        parent::__construct($message, $code, $previous);
    }

    public function getErrorMessage()
    {
        return $this->message;
    }

    public function getStatusCode()
    {
        return $this->code;
    }

    public function getDebug()
    {
        return $this->debug;
    }
}
