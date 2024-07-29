<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // index
    public function index(Request $request)
    {
        // get all users with pagination
        $users = DB::table('users')
            ->when($request->input('name'), function ($query, $name) {
                $query->where('name', 'like', '%' . $name . '%')
                    ->orWhere('email', 'like', '%' . $name . '%');
            })
            ->paginate(10);
        return view('pages.users.index', compact('users'));
    }

    // create
    public function create()
    {
        return view('pages.users.create');
    }

    // store
    public function store(Request $request)
    {
        // validate
        $request->validate(
            [
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required|min:6',
                'role' => 'required|in:admin,user,staff',
            ]
        );

        // create user
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;
        $user->save();

        // redirect
        return redirect()->route('users.index')->with('success', 'User created successfully');
    }

    // show
    public function show($id)
    {
        // return view
        return view('users.show', compact('user'));
    }



    // edit
    public function edit($id)
    {
        // find user by id
        // $user = User::find($id);
        $user = User::findOrFail($id);

        // return view
        return view('pages.users.edit', compact('user'));
    }

    // update
    public function update(Request $request, $id)
    {
        // validate
        $request->validate(
            [
                'name' => 'required',
                'email' => 'required|email',
                'role' => 'required|in:admin,user,staff',
            ]
        );

        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->save();

        if ($request->password) {
            $user->password = Hash::make($request->password);
            $user->save();
        }

        // redirect
        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    // destroy
    public function destroy($id)
    {
        // // find user by id
        $user = User::find($id);

        // // delete user
        $user->delete();

        // // redirect
        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }
}
