<?php

namespace App\Repositories\Contracts;
use App\Repositories\Contracts\RepositoryInterface;

interface UserInterface extends RepositoryInterface
{
    public function register($inputs);
}
