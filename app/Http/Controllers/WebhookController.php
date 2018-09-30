<?php namespace App\Http\Controllers;

use App\Models\Project;
use App\Http\Controllers\DeployController;
use App\Http\Controllers\Controller;
use App\Services\DeploymentService;
use Illuminate\Http\Request;


/**
 * Class WebhookController
 * @package App\Http\Controllers\API\V1
 */
class WebhookController extends Controller {

    const GITHUB_EVENT = 'pull_request';

    /**
     * Run deployment process if was pull request to github repo
     *
     * @param $request
     * @param $slug
     */
    public function runDeploy(Request $request, DeploymentService $deployment,$slug) {
        $project = Project::where('slug', $slug)->first();

        if (!$project) {
            //return response to github
            abort(404);
        }

        //TODO get hashed key from X-Hub-Signature header and check with data base secret field
        $hash = $request->header('X-Hub-Signature');
        $event = $request->header('X-GitHub-Event');

        if (($hash == 'sha1=' . $project->hash) && $event == self::GITHUB_EVENT) {
            return $deployment->runAction($project, 'artisan-migrate');
        }
    }
}
