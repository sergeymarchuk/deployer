<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\RemoteArtisan;
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
    public function exec(string $action)
    {
        $path = '/home/svystun/www/stage.cf15.pro';

        if ($action == 'artisan-migrate') {
            return RemoteArtisan::call($path, 'migrate', ['--force' => true]);
        }

        $commands = [
            'git-pull' => 'git pull',
            'composer-install' => 'composer install'
        ];

        $process = new Process('cd '. $path .' && ' . $commands[$action]);

        try {
            $process->mustRun();
            return $process->getOutput();
        } catch (ProcessFailedException $exception) {
            return $exception->getMessage();
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function artisanMigrate()
    {
        return view('home');
    }
}