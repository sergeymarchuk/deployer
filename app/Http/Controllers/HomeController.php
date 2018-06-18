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
     * @return \Illuminate\Http\JsonResponse
     */
    public function exec(string $action)
    {
        $commands = [
            'git-pull' => 'git pull',
            'composer-install' => 'composer install',
            'artisan-migrate' => '/usr/bin/php /home/svystun/www/stage.cf15.pro/artisan migrate --force'
        ];

        echo RemoteArtisan::call('/home/svystun/www/stage.cf15.pro/', 'migrate', ['--force' => true]);

//        $process = new Process('cd /home/svystun/www/stage.cf15.pro && ' . $commands[$action]);
//
//        try {
//            $process->mustRun();
//            echo $process->getOutput();
//        } catch (ProcessFailedException $exception) {
//            echo $exception->getMessage();
//        }

        return response()->json(['df' => mt_rand(1000, 1000000)]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function artisanMigrate()
    {
        return view('home');
    }
}