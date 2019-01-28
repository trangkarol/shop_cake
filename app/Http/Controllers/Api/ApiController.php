<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Exceptions\Api\NotFoundException;
use App\Exceptions\Api\UnknowException;
use App\Exceptions\Api\UnknowExceptionMessage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Exception;

class ApiController extends Controller
{
    protected $guard = 'api';
    protected $table;
    protected $message;
    protected $compacts = [];

    /**
     * Define response of API.
     *
     */
    protected function trueJson()
    {
        $this->compacts['code'] = Response::HTTP_OK;

        return response()->json($this->compacts);
    }

    /**
     * Function to control insert, update, delete.
     *
     * @param callable $callback
     * @return \Illuminate\Http\JsonResponse
     * @throws NotFoundException
     * @throws UnknowException
     */
    protected function doAction(callable $callback)
    {
        DB::beginTransaction();

        try {
            if (is_callable($callback)) {
                call_user_func($callback);
            }

            DB::commit();
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            $message = $e->getMessage() ?: null;

            throw new NotFoundException($e->getMessage(), Response::HTTP_NOT_FOUND, $this->table, $message, $e);
        } catch (Exception $e) {
            DB::rollBack();
            $message = $this->message ?: null;

            throw new UnknowException($e->getMessage(), $e->getCode(), $this->table, $message, $e);
        }

        return $this->trueJson();
    }

    /**
     * Function to control get data.
     *
     * @param callable $callback
     * @return \Illuminate\Http\JsonResponse
     * @throws NotFoundException
     * @throws UnknowException
     */
    protected function getData(callable $callback)
    {
        try {
            if (is_callable($callback)) {
                call_user_func($callback);
            }
        } catch (ModelNotFoundException $e) {
            throw new NotFoundException($e->getMessage(), Response::HTTP_NOT_FOUND, $this->table, null, $e);
        } catch (Exception $e) {
            throw new UnknowException($e->getMessage(), $e->getCode(), $this->table, null, $e);
        }

        return $this->trueJson();
    }
}
