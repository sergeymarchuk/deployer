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
            try {
                $process = new RemoteArtisan($project['path'], 'migrate', ['--force' => true]);
                return $process->run();
            } catch (ProcessFailedException $exception) {
                return $exception->getMessage();
            }
        }

        $commands = [
            'git-pull' => 'git pull',
            'composer-install' => 'composer install'
        ];

        // Run process
        $process = new Process($commands[$action], $project['path']);

        try {
            $process->mustRun();
            return $process->getOutput();
        } catch (ProcessFailedException $exception) {
            return $exception->getMessage();
        }
    }
}