<?php

namespace App\Http\Controllers;

use Gate;
use App\Http\Requests\StorePermissionRequest;
use App\Models\Permission;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\Datatables\Datatables;

class PermissionsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('permission_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if(request()->ajax()){
            $permissions = Permission::select('id','title')->get();
            return Datatables::of($permissions)
                ->addColumn('action',function($permission){
                    return view('permissions.datatables.action',compact('permission'));
                })
                ->make(true);
        }

        return view('permissions.index');
    }

    public function create()
    {
        abort_if(Gate::denies('permission_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('permissions.create');
    }

    public function store(StorePermissionRequest $request)
    {
        try{
            Permission::create($request->validated());
            return redirect()->route('permissions.index')->with('success',__('Permission created successfully!!'));
        }catch(\Exception $e){
            report($e);
            return redirect()->back()->with('error',__('Something goes wrong!!'));
        }
    }

    public function show(Permission $permission)
    {
    }

    public function edit(Permission $permission)
    {
        abort_if(Gate::denies('permission_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('permissions.edit', compact('permission'));
    }

    public function update(StorePermissionRequest $request, Permission $permission)
    {
        try{
            $permission->update($request->validated());
            return redirect()->route('permissions.index')->with('success',__('Permission updated successfully!!'));
        }catch(\Exception $e){
            report($e);
            return redirect()->back()->with('error',__('Something goes wrong!!'));
        }
    }

    public function destroy(Permission $permission)
    {
        abort_if(Gate::denies('permission_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        try{
            $permission->delete();
            return redirect()->back()->with('success',__('Permission deleted successfully!!'));
        }catch(\Exception $e){
            report($e);
            return redirect()->back()->with('error',__('Something goes wrong!!'));
        }
    }
}
