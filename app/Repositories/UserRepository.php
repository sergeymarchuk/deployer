<?php namespace App\Repositories;

use App\Models\User;

/**
 * Class UserRepository
 * @package App\Repositories
 */
class UserRepository extends AbstractRepository
{
    /**
     * @var User $model
     */
    protected $model;

    /**
     * UserRepository constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }
}