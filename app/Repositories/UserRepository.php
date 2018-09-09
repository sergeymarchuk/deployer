<?php namespace App\Repositories;

use App\Models\User;

/**
 * Class UserRepository
 * @package App\Repositories
 */
class UserRepository extends Repository
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }
}