<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRoleRequest;
use Gate;
use Symfony\Component\HttpFoundation\Response;
use Yajra\Datatables\Datatables;

class RolesController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('role_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if(request()->ajax()){
            $roles = Role::with('permissions:id,title')->select('id','title')->get();

            return Datatables::of($roles)
                ->addColumn('action',function($role){
                    return view('roles.datatables.action',compact('role'));
                })
                ->rawColumns(['permissions','action'])
                ->make(true);
        }

        return view('roles.index');
    }

    public function create()
    {
        abort_if(Gate::denies('role_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $permissions = Permission::all()->pluck('title', 'id');

        return view('roles.create',compact('permissions'));
    }

    public function store(StoreRoleRequest $request)
    {
        try{
            $role = Role::create($request->validated());
            $role->permissions()->sync($request->input('permissions', []));
            return redirect()->route('roles.index')->with('success','Role created successfully!!');
        }catch(\Exception $e){
            report($e);
            return redirect()->back()->with('error',__('Something goes wrong!!'));
        }
    }

    public function show(Role $role)
    {
    }

    public function edit(Role $role)
    {
        abort_if(Gate::denies('role_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $permissions = Permission::all()->pluck('title', 'id');

        $role->load('permissions');

        return view('roles.edit', compact('permissions', 'role'));
    }

    public function update(StoreRoleRequest $request, Role $role)
    {
        try{
            $role->update($request->validated());
            $role->permissions()->sync($request->input('permissions', []));
            return redirect()->route('roles.index')->with('success','Role updated successfully!!');
        }catch(\Exception $e){
            report($e);
            return redirect()->back()->with('error',__('Something goes wrong!!'));
        }
    }

    public function destroy(Role $role)
    {
        try{
            $role->delete();
            return redirect()->route('roles.index')->with('success','Role deleted successfully!!');
        }catch(\Exception $e){
            report($e);
            return redirect()->back()->with('error',__('Something goes wrong!!'));
        }
    }
}
