<?php

namespace App\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Container\Container as App;
use App\Repositories\Contracts\RepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Auth;

abstract class BaseRepository implements RepositoryInterface
{
    protected $model;

    protected $app;

    protected $guards;

    protected $user;

    public function __construct()
    {
        $this->app = new App();
        $this->makeModel();
    }

    /**
     * to call relationship in model
     *
     * @return relationship
    */
    public function __call($method, $args)
    {
        $model = $this->model;

        if ($method == head($args)) {
            $this->model = call_user_func_array([$model, $method], array_diff($args, [head($args)]));

            return $this;
        }

        if (!$model instanceof Model) {
            $model = $model->first();

            if (!$model) {
                throw new ModelNotFoundException();
            }
        }

        $this->model = call_user_func_array([$model, $method], $args);

        return $this;
    }

    /**
     * to call eager loading
     *
     * @return collection
    */
    public function __get($name)
    {
        $model = $this->model;

        if (!$model instanceof Model) {
            $model = $model->first();

            if (!$model) {
                throw new ModelNotFoundException();
            }
        }

        return $model->$name;
    }

    abstract public function model();

    public function setGuard($guard = null)
    {
        $this->guard = $guard;
        $this->user = Auth::guard($this->guard)->user();

        return $this;
    }

    public function makeModel()
    {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model) {
            throw new Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }

    /**
     * function all to get all data of model.
     *
     * @return void
    */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * to get lists columns.
     *
     * @return void
    */
    public function lists($column, $key = null)
    {
        $model = $this->model->pluck($column, $key);
        $this->makeModel();

        return $model;
    }

    public function paginate($limit = null, $columns = ['*'])
    {
        $limit = $limit ?: config('setting.paginate');
        $model = $this->model->paginate($limit, $columns);
        $this->makeModel();

        return $model;
    }

    public function find($id, $columns = ['*'])
    {
        return $this->model->find($id, $columns);
    }

    public function findOrFail($id, $columns = ['*'])
    {
        try {
            $model = $this->model->findOrFail($id, $columns);
            $this->makeModel();

            return $model;
        } catch (ModelNotFoundException $e) {
            throw new \App\Exceptions\Api\NotFoundException('Model not found with id:' . $id, NOT_FOUND);
        }
    }
}
