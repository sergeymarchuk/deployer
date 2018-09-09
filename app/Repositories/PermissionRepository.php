<?php namespace App\Repositories;

use Spatie\Permission\Models\Permission;

/**
 * Class PermissionRepository
 * @package App\Repositories
 */
class PermissionRepository extends AbstractRepository
{
    /**
     * @var Permission $model
     */
    protected $model;

    /**
     * PermissionRepository constructor.
     *
     * @param Permission $permission
     */
    public function __construct(Permission $permission)
    {
        $this->model = $permission;
    }
}