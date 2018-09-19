<?php namespace App\Repositories;

use Spatie\Permission\Models\Role;

/**
 * Class RoleRepository
 * @package App\Repositories
 */
class RoleRepository extends AbstractRepository
{
    /**
     * @var Role $model
     */
    protected $model;

    /**
     * RoleRepository constructor.
     * @param Role $role
     */
    public function __construct(Role $role)
    {
        $this->model = $role;
    }
}