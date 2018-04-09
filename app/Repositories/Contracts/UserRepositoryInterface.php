<?php

namespace App\Repositories\Contracts;

interface UserRepositoryInterface
{

    public function create($attributes);

    public function findByUsername($username);

}