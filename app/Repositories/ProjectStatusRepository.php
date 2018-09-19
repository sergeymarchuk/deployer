<?php namespace App\Repositories;

use App\Models\ProjectStatus;

/**
 * Class ProjectStatusRepository
 * @package App\Repositories
 */
class ProjectStatusRepository extends AbstractRepository
{
    /**
     * @var ProjectStatus $model
     */
    protected $model;

    /**
     * ProjectStatusRepository constructor.
     * @param ProjectStatus $project
     */
    public function __construct(ProjectStatus $project)
    {
        $this->model = $project;
    }
}