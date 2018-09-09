<?php namespace App\Repositories;

use App\Models\ProjectStatus;

/**
 * Class ProjectStatusRepository
 * @package App\Repositories
 */
class ProjectStatusRepository extends Repository
{
    public function __construct(ProjectStatus $project)
    {
        parent::__construct($project);
    }
}