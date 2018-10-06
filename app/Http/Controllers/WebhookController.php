<?php namespace App\Http\Controllers;

use App\Repositories\ProjectRepository;
use App\Services\DeploymentService;
use Illuminate\Support\Facades\Log;

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
     * @param DeploymentService $deployment
     * @param $slug
     * @return mixed|string
     */
    public function runDeploy(DeploymentService $deployment, $slug) {

        $project = $this->projectRepo->getModel()->where('slug', $slug)->first();

        if (!$project) {
            abort(404);
        }

        //$github = $request->header('X-Hub-Signature');
        //$bitbucket = $request->header('X-Request-UUID');

        $response = [];
        foreach (DeploymentService::COMMANDS as $command => $value) {
            $status = $deployment->runAction($project, $command, 'text');
            if ($status == DeploymentService::STATUS_ERROR) {
                Log::warning($command. ' ' .$status);
                $response[$command] = $status;
                break;
            }
            $response[$command] = $status;
        }
        return $response;
    }
}