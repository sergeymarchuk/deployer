<?php namespace App\Repositories;

use Spatie\Permission\Models\Role;

/**
 * Class RoleRepository
 * @package App\Repositories
 */
class RoleRepository extends Repository
{
    public function __construct(Role $role)
    {
        parent::__construct($role);
    }
}