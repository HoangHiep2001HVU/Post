<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function __construct(){
        $this->middleware(['guest']);
    }
 
    public function index()
    {
        return view('auth.register');
    }

    public function store(Request $request){
        
       $this->validate($request, [
        'name' => 'required|max:191',
        'username' => 'required|max:191',
        'email' => 'required|email|max:191', 
        'password' => 'required|confirmed',
       ]);
        
       User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
       ]);

        auth()->attempt($request->only('email', 'password'));

       return redirect()->route('dashboard');

    }
}
