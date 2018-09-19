<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\{RoleRepository, PermissionRepository};
use App\Http\Requests\{StoreRolesRequest, UpdateRolesRequest};

/**
 * Class RolesController
 * @package App\Http\Controllers\Admin
 */
class RolesController extends Controller
{
    /**
     * @var PermissionRepository $permissionRepo
     */
    protected $permissionRepo;

    /**
     * @var RoleRepository $roleRepo
     */
    protected $roleRepo;

    /**
     * RolesController constructor.
     *
     * @param PermissionRepository $permissionRepo
     * @param RoleRepository $roleRepo
     */
    public function __construct(PermissionRepository $permissionRepo, RoleRepository $roleRepo)
    {
        $this->permissionRepo = $permissionRepo;
        $this->roleRepo = $roleRepo;
    }

    /**
     * Display a listing of Role.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = $this->roleRepo->all();

        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating new Role.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = $this->permissionRepo->all()->pluck('name', 'name');

        return view('roles.create', compact('permissions'));
    }

    /**
     * Store a newly created Role in storage.
     *
     * @param  \App\Http\Requests\StoreRolesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRolesRequest $request)
    {
        $role = $this->roleRepo->create($request->except('permission'));
        $permissions = $request->input('permission') ? $request->input('permission') : [];
        $role->givePermissionTo($permissions);

        return redirect()->route('roles.index');
    }


    /**
     * Show the form for editing Role.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permissions = $this->permissionRepo->all()->pluck('name', 'name');
        $role = $this->roleRepo->findOrFail($id);

        return view('roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update Role in storage.
     *
     * @param  \App\Http\Requests\UpdateRolesRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRolesRequest $request, $id)
    {
        $role = $this->roleRepo->findOrFail($id);
        $role->update($request->except('permission'));
        $permissions = $request->input('permission') ? $request->input('permission') : [];
        $role->syncPermissions($permissions);

        return redirect()->route('roles.index');
    }


    /**
     * Remove Role from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = $this->roleRepo->findOrFail($id);
        $role->delete();

        return redirect()->route('roles.index');
    }

    /**
     * Delete all selected Role at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if ($request->input('ids')) {
            $entries = $this->roleRepo->getModel()->whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }

}
