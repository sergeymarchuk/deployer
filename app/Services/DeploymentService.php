<?php namespace App\Services;

use App\Models\Project;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

/**
 * Class DeploymentService
 * @package App\Services
 */
class DeploymentService
{
    const COMMANDS = [
        'git-pull' => 'git pull',
        'composer-install' => 'composer install',
        'artisan-migrate' => 'migrate'
    ];

    /**
     * @param Project $project
     * @param string $action
     * @return mixed|string
     */
    public function runAction(Project $project, string $action)
    {
        //TODO: Check if path exists and artisan file

        $process = ($action == 'artisan-migrate') ?
            new ArtisanService($project->path, self::COMMANDS[$action], ['--force' => true]) :
            new Process(self::COMMANDS[$action], $project->path);

        try {
            $text = ($process instanceof Process) ?
                $process->mustRun()->getOutput() :
                $process->run();
            return $this->jsonResponse($text, 'ok');
        } catch (ProcessFailedException $exception) {
            return $this->jsonResponse($exception->getMessage(), 'error');
        }
    }

    /**
     * @param string $message
     * @param string $status
     * @return \Illuminate\Http\JsonResponse
     */
    protected function jsonResponse(string $message, string $status)
    {
        return response()->jsonp('checkAndRun', [
            'status' => $status,
            'message' => $message,
            'next' => request('next', ''),
            'prev' => request('prev', '')
        ]);
    }
}