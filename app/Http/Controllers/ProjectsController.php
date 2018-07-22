<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DeploymentService;
use Illuminate\Support\Facades\Auth;
use App\Models\{Project, ProjectStatus};
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Http\Requests\{StoreProjectsRequest,UpdateProjectsRequest};

/**
 * Class ProjectsController
 * @package App\Http\Controllers
 */
class ProjectsController extends Controller
{
    /**
     * ProjectsController constructor.
     */
    public function __construct()
    {
        // Allow just view of projects
        $this->middleware('can:projects_manage', [
            'except' => ['index', 'home']
        ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        return view('home');
    }

    /**
     * Display a listing of Project.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::all();

        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating new Project.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $relations = [
            'project_statuses' => ProjectStatus::get()->pluck('title', 'id')->prepend('Please select', ''),
        ];

        return view('projects.create', $relations);
    }

    /**
     * Store a newly created Project in storage.
     *
     * @param  \App\Http\Requests\StoreProjectsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectsRequest $request)
    {
        Project::create($request->all());

        return redirect()->route('projects.index');
    }

    /**
     * Show the form for editing Project.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     */
    public function edit($id)
    {
        $relations = [
            'project_statuses' => ProjectStatus::get()->pluck('title', 'id')->prepend('Please select', ''),
        ];

        $project = Project::findOrFail($id);

        return view('projects.edit', compact('project') + $relations);
    }

    /**
     * Update Project in storage.
     *
     * @param  \App\Http\Requests\UpdateProjectsRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectsRequest $request, $id)
    {
        $project = Project::findOrFail($id);
        $project->update($request->all());

        return redirect()->route('projects.index');
    }

    /**
     * Display Project.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $relations = [
            'project_statuses' => ProjectStatus::get()->pluck('title', 'id')->prepend('Please select', ''),
        ];

        $project = Project::findOrFail($id);

        return view('projects.show', compact('project') + $relations);
    }

    /**
     * Remove Project from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();

        return redirect()->route('projects.index');
    }

    /**
     * Delete all selected Project at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if ($request->input('ids')) {
            $entries = Project::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }
}
