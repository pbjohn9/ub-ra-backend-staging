<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Http\Request;
use Gate;
use Symfony\Component\HttpFoundation\Response;
use Yajra\Datatables\Datatables;

class UsersController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if(request()->ajax()){
            $users = User::select('id','name','email')->get();
            return Datatables::of($users)
                ->addColumn('action',function($user){
                    return view('users.datatables.action',compact('user'));
                })
                ->addColumn('role',function($user){
                    return $user->roles()->pluck('title')->toArray();
                })
                ->make(true);
        }

        return view('users.index');
    }

    public function create()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::all()->pluck('title', 'id');

        return view('users.create',compact('roles'));
    }

    public function store(StoreUserRequest $request)
    {
        try{
            $user = User::create($request->validated());
            $user->roles()->sync($request->input('roles', []));
            return redirect()->route('users.index')->with('success',__('User created successfully!!'));
        }catch(\Exception $e){
            report($e);
            return redirect()->back()->with('error',__('Something goes wrong!!'));
        }
        
    }

    public function show(User $user)
    {
    }

    public function edit(User $user)
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::all()->pluck('title', 'id');

        $user->load('roles');

        return view('users.edit', compact('roles', 'user'));
    }

    public function update(StoreUserRequest $request, User $user)
    {
        try{
            $user->update($request->validated());
            $user->roles()->sync($request->input('roles', []));
            return redirect()->route('users.index')->with('success',__('User updated successfully!!'));
        }catch(\Exception $e){
            report($e);
            return redirect()->back()->with('error',__('Something goes wrong!!'));
        }
    }

    public function destroy(User $user)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        try{
            $user->delete();
            return redirect()->back()->with('success',__('User deleted successfully!!'));
        }catch(\Exception $e){
            report($e);
            return redirect()->back()->with('error',__('Something goes wrong!!'));
        }
    }
}
