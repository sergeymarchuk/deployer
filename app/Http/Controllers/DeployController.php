<?php namespace App\Http\Controllers;

use App\Services\DeploymentService;
use App\Models\Project;

/**
 * Class ProjectsController
 * @package App\Http\Controllers
 */
class DeployController extends Controller
{
    /**
     * Show project deploy page
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function deployPage($id)
    {
        $project = Project::findOrFail($id);
        return view('deploy', compact('project'));
    }

    /**
     * Run action for deploy
     *
     * @param int $id
     * @param string $action
     * @param DeploymentService $deployment
     * @return mixed
     */
    public function deployAction(int $id, string $action, DeploymentService $deployment)
    {
        $project = Project::findOrFail($id);
        return $deployment->runAction($project, $action);
    }
}
