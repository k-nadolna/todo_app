<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function login(Request $request){
        $incomigFields = $request->validate([
            'loginname' => 'required',
            'loginpassword' => 'required'
        ]);

        if(auth()->attempt(['name' => $incomigFields['loginname'], 'password'=> $incomigFields['loginpassword']])){
            $request->session()->regenerate();
            
            };

        return redirect('/');
    }

    public function logout(){
        auth()->logout();
        return redirect('/');
    }

    public function register(Request $request) {
      $incomigFields = $request->validate([
        'name' => 'required',
        'email' => 'required',
        'password' => ['required', 'min:3']
      ]);

      $incomigFields['password'] = bcrypt($incomigFields['password']);

      $user = User::create($incomigFields);
      auth()->login($user);
      
      return redirect('/');

    }

    public function showDashboard(){
        $tasks = [];
    if(auth()->check()){
        $tasks =  auth()->user()->usersCoolTasks()->latest()->get();
    }
       
        return view('home', ['tasks'=> $tasks]);

    }
}
