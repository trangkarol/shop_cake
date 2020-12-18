<?php

namespace App\Repositories\Contracts;

interface RepositoryInterface
{
    public function all();

    public function withTrashed();

    public function onlyTrashed();

    public function makeModel();

    public function lists($column, $key = null);

    public function paginate($limit = null, $columns = ['*']);

    public function find($id, $columns = ['*']);

    public function findOrFail($id, $columns = ['*']);
}
