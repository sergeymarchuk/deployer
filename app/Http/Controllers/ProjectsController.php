<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Repositories\{ProjectRepository, ProjectStatusRepository, UserRepository};
use App\Http\Requests\{StoreProjectsRequest, UpdateProjectsRequest};

/**
 * Class ProjectsController
 * @package App\Http\Controllers
 */
class ProjectsController extends Controller
{
    /**
     * @var ProjectRepository $projectRepository
     */
    protected $projectRepo;

    /**
     * @var ProjectStatusRepository $projectStatusRepository
     */
    protected $projectStatusRepo;

    /**
     * @var UserRepository $userRepository
     */
    protected $userRepo;

    /**
     * ProjectsController constructor.
     *
     * @param ProjectRepository $projectRepo
     * @param ProjectStatusRepository $projectStatusRepo
     * @param UserRepository $userRepo
     */
    public function __construct(
        ProjectRepository $projectRepo,
        ProjectStatusRepository $projectStatusRepo,
        UserRepository $userRepo)
    {
        // Allow just view of projects
        $this->middleware('can:projects_manage', [
            'except' => ['index']
        ]);
        $this->projectRepo = $projectRepo;
        $this->projectStatusRepo = $projectStatusRepo;
        $this->userRepo = $userRepo;
    }

    /**
     * Display a listing of Project.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = $this->projectRepo->all();

        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating new Project.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $projectStatuses = $this->projectStatusRepo->all()->pluck('title', 'id')->prepend('Please select', '');
        $users = $this->userRepo->all()->pluck('name', 'id');

        return view('projects.create', compact('projectStatuses', 'users'));
    }

    /**
     * Store a newly created Project in storage.
     *
     * @param  \App\Http\Requests\StoreProjectsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectsRequest $request)
    {
        $slug = str_random(20);
        $project = $this->projectRepo->create([
            'title'             => $request->input('title'),
            'path'              => $request->input('path'),
            'project_status_id' => $request->input('project_status_id'),
            'webhook'           => URL::to('/').'/api/v1/'.$slug,
            'slug'              => $slug
        ]);

        if ($deployers = $request->input('deployer')) {
            $project->users()->sync($deployers);
        }

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
        $projectStatuses = $this->projectStatusRepo->all()->pluck('title', 'id')->prepend('Please select', '');
        $project = $this->projectRepo->findOrFail($id);
        $users = $this->userRepo->all()->pluck('name', 'id');

        return view('projects.edit', compact('projectStatuses', 'project', 'users'));
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
        $project = $this->projectRepo->findOrFail($id);
        $project->update($request->all());

        if ($deployers = $request->input('deployer')) {
            $project->users()->sync($deployers);
        }

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
            'project_statuses' => $this->projectStatusRepo->all()->pluck('title', 'id')->prepend('Please select', ''),
        ];

        $project = $this->projectRepo->findOrFail($id);

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
        $project = $this->projectRepo->findOrFail($id);
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
            $entries = $this->projectRepo->getModel()->whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }
}
