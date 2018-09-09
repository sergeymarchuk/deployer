<?php namespace App\Repositories;

use App\Models\Project;

/**
 * Class ProjectRepository
 * @package App\Repositories
 */
class ProjectRepository extends Repository
{
    public function __construct(Project $project)
    {
        parent::__construct($project);
    }
}