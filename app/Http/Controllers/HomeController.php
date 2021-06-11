<?php

namespace App\Http\Controllers;

use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function viewProfile(){
        abort_if(Gate::denies('profile_password_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = auth()->user();

        return view('profile',compact('user'));
    }

    public function updateProfile(Request $request){
        $request->validate([
            'name' => ['required'],
            'email' => ['required','unique:users,email,'.auth()->id()],
            'password' => ['nullable'],
        ]);

        try{
            auth()->user()->update($request->post());
            return redirect()->back()->with('success','Profile updated successfully!!');
        }catch(\Exception $e){
            report($e);
            return redirect()->back()->with('error',__('Something goes wrong!!'));
        }
    }
}
