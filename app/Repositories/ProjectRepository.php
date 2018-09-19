<?php namespace App\Repositories;

use App\Models\Project;

/**
 * Class ProjectRepository
 * @package App\Repositories
 */
class ProjectRepository extends AbstractRepository
{
    /**
     * @var Project $model
     */
    protected $model;

    /**
     * ProjectRepository constructor.
     * @param Project $project
     */
    public function __construct(Project $project)
    {
        $this->model = $project;
    }
}