<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Service\RemoteArtisan;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    /**
     * @param string $action
     * @return mixed|string
     */
    public function runAction(string $action)
    {
        //TODO: Implement functionality: Get project by id
        $project['path'] = '/home/svystun/www/stage.cf15.pro';

        if ($action == 'artisan-migrate') {
            $process = new RemoteArtisan($project['path'], 'migrate', ['--force' => true]);
            return $this->getResponse($process);
        }

        $commands = [
            'git-pull' => 'git pull',
            'composer-install' => 'composer install'
        ];

        // Run process
        $process = new Process($commands[$action], $project['path']);

        return $this->getResponse($process);
    }

    /**
     * @param $process
     * @return \Illuminate\Http\JsonResponse
     */
    protected function getResponse($process)
    {
        try {
            $text = ($process instanceof Process) ? $process->mustRun()->getOutput() : $process->run();
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
    protected function jsonResponse(string $message, string $status) {
        return response()->jsonp('checkAndRun', [
            'status' => $status,
            'message' => $message,
            'next' => request('next', ''),
            'prev' => request('prev', '')
        ]);
    }
}