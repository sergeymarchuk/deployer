<?php namespace App\Repositories;

use Spatie\Permission\Models\Permission;

/**
 * Class PermissionRepository
 * @package App\Repositories
 */
class PermissionRepository extends Repository
{
    public function __construct(Permission $permission)
    {
        parent::__construct($permission);
    }
}