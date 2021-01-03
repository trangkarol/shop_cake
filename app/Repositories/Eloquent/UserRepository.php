<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Contracts\UserInterface;
use App\Traits\HandleImage;

class UserRepository extends BaseRepository implements UserInterface
{
    use HandleImage;

    public function model()
    {
        return User::class;
    }

    public function register($inputs)
    {
        $inputs['avatar'] = $this->uploadImage($inputs['avatar']);
        $user = $this->model->create($inputs);

        if (!$user) {
            throw new UnknowException('Had errors while processing');
        }

        return $user;
    }
}
