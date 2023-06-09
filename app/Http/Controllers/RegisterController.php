<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {

        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.register');
    }
    public function store(Request $request)
    {
        $store = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'role_id' => 3,
            'password' => Hash::make($request->password),
        ]);
        if($store){
            return redirect()->route('login')->with('success', 'Register Berhasil, silahkan login');
        }else{
            return redirect()->back()->with('error', 'Register gagal, silahkan coba lagi');
        }
    }
}

