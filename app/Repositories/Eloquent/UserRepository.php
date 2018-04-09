<?php

namespace App\Repositories\Eloquent;

use App\Entities\User;
use App\Repositories\Repository;
use App\Repositories\Contracts\UserRepositoryInterface;

/**
 * Class UserRepository
 * @package App\Repositories\Eloquent
 */
class UserRepository extends Repository implements UserRepositoryInterface
{
    /**
     * @var \App\Entities\User
     */
    protected $model;

    /**
     * UserRepository constructor.
     *
     * @param \App\Entities\User $user
     */
    public function __construct(User $user)
    {
        parent::__construct($user);
        //        $this->model = $user;
    }

    /**
     * Get all users.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * Get a new instance of the model.
     *
     * @param  array $attributes
     *
     * @return \App\Entities\User
     */
    public function getNew(array $attributes = array())
    {
        return $this->model->newInstance($attributes);
    }

    /**
     * Get User Model.
     *
     * @return \App\Entities\User
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param $username
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function findByUsername($username)
    {
        return $this->model->where('username', '=', $username)->first();
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $attributes
     *
     * @return \App\Entities\User
     * @static
     */
    public function create($attributes)
    {
        return $this->model->create($attributes);
    }
}