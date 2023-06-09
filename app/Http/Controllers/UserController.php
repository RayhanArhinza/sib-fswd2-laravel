<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('role')->get();
        return view('user.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('user.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2',
            'email' => 'required|string',
            'phone' => 'required|string|min:10',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'role' => 'required|numeric',
            'password' => 'required|string|min:2',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // ubah nama file
        $imageName = time() . '.' . $request->image->extension();

        // simpan file ke folder public/user
        Storage::putFileAs('public/user', $request->image, $imageName);
        // Simpan data ke database
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'image' => $imageName,
            'role_id' => $request->role,
            'password' => bcrypt($request->password)
        ]);
        return redirect()->route('user.index');
    }

    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::all();

        return view('user.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2',
            'email' => 'required|string',
            'phone' => 'required|string|min:10',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'role' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        // cek jika user mengupload gambar di form
        if ($request->hasFile('image')) {
            // ambil nama file gambar lama dari database
            $old_image = User::find($id)->image;

            // hapus file gambar lama dari folder user
            Storage::delete('public/user/'.$old_image);

            // ubah nama file
            $imageName = time() . '.' . $request->image->extension();

            // simpan file ke folder public/user
            Storage::putFileAs('public/user', $request->image, $imageName);

            // update data user
            User::where('id', $id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'image' => $imageName,
                'role_id' => $request->role,
            ]);

        } else {
            // update data user tanpa menyertakan file gambar
            User::where('id', $id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'role_id' => $request->role,
            ]);
        }

        return redirect()->route('user.index');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->route('user.index');
    }
}