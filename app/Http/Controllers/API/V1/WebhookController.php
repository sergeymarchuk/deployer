<?php namespace App\Http\Controllers\API\V1;

use App\Models\Project;
use App\Services\DeploymentService;
use App\Http\Controllers\DeployController;

/**
 * Class WebhookController
 * @package App\Http\Controllers\API\V1
 */
class WebhookController extends Controller {

    /**
     * Run deployment process if was pull request to github repo
     *
     * @param $request
     * @param $slug
     */
    public function runDeploy($slug) {
        $project = Project::where('slug', $slug)->get();
        $secret = $_SERVER['HTTP_' . strtoupper('X-Hub-Signature')];
        $event = $_SERVER['HTTP_' . strtoupper('X-Hub-Event')];


        // TODO need define deploymentServices in deployment variable
        if ($secret == $project->hash && $event == 'pull_request') {
            DeployController::deployAction($project->id, 'git-pull', DeploymentService::class);
        }


    }
}
