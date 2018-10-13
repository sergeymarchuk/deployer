<?php namespace App\Services;

use App\Models\Project;
use Dotenv\Dotenv;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

/**
 * Class DeploymentService
 * @package App\Services
 */
class DeploymentService
{
    const STATUS_OK = 'OK';
    const STATUS_ERROR = 'ERROR';
    const COMMANDS = [
        'git-pull' => 'git pull',
        'composer-install' => 'composer install',
        'artisan-migrate' => 'migrate'
    ];

    /**
     * @param Project $project
     * @param string $action
     * @param string $response
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function runAction(Project $project, string $action, string $response = 'jsonp')
    {
        if (!is_dir($project->path)) {
            return false; //maybe throw Exception
        }

        try {

            if ($action == 'artisan migrate') {
                $options = $this->getOptions(['--force' => true]);
                $text = $this->run($project->path, self::COMMANDS[$action], $options);
            } else {
                $process = new Process(self::COMMANDS[$action], $project->path);
                $text = $process->mustRun()->getOutput();
            }

            $status = self::STATUS_OK;
        } catch (ProcessFailedException $exception) {
            $text = $exception->getMessage();
            $status = self::STATUS_ERROR;
        }

        if ($response == 'jsonp') {
            return $this->jsonResponse($text, $status);
        }

        return $status;
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

    protected function run(string $path, string $command, $options, $php = null) {

        // Swap out the full path to the current PHP executable binary
        if (! $php) {
            $php = PHP_BINDIR . '/php';
        }

        // Load .env for the target app
        $env = new Dotenv($path);
        $env->overload();

        // Run the command in its environment
        $process = new Process($this->getCommand($path, $command, $php, $options ), $path);
        $process->run();

        // Restore original environment
        $env = new Dotenv(base_path());
        $env->overload();

        // If there was no response
        if (! $process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return $process->getOutput();
    }

    private function getCommand($path, $command, $php, $options) {
        // Append the artisan command to the path
        $artisan = Str::finish($path, '/').'artisan';

        // Build up the final command
        return "{$php} {$artisan} {$command}{$options}";
    }

    private function getOptions($parameters = []) {
        $options = '';
        foreach ($parameters as $name => $value) {

            if (is_int($name)) {
                $options .= " $value";
            } else {
                $value = $value === true ? '' : '="'.$value.'"';
                $options .= " {$name}{$value}";
            }
        }

        return $options;
    }
}