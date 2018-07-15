<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DeploymentService;

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
     * @param DeploymentService $deployment
     * @return mixed
     */
    public function deploy(string $action, DeploymentService $deployment)
    {
        return $deployment->runAction($action);
    }
}