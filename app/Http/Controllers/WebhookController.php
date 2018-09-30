<?php namespace App\Http\Controllers;

use App\Repositories\ProjectRepository;
use App\Services\DeploymentService;
use Illuminate\Http\Request;

/**
 * Class WebhookController
 * @package App\Http\Controllers\API\V1
 */
class WebhookController extends Controller {

    /**
     * @var ProjectRepository $projectRepository
     */
    protected $projectRepo;

    /**
     * ProjectsController constructor.
     *
     * @param ProjectRepository $projectRepo
     */
    public function __construct(ProjectRepository $projectRepo)
    {
        $this->projectRepo = $projectRepo;
    }

    /**
     * Run deployment process if was pull request to github repo
     *
     * @param Request $request
     * @param DeploymentService $deployment
     * @param $slug
     * @return mixed|string
     */
    public function runDeploy(Request $request, DeploymentService $deployment,$slug) {
        $project = $this->projectRepo->getModel()->where('slug', $slug)->first();

        if (!$project) {
            //return response to github
            abort(404);
        }

        //TODO get hashed key from X-Hub-Signature header and check with data base secret field
        $hash = $request->header('X-Hub-Signature');

        if (($hash == 'sha1=' . $project->hash)) {
            return $deployment->runAction($project, 'git-pull');
        }

        return $deployment->runAction($project, 'git-pull');

        //return ['Hook not found'];
    }
}
