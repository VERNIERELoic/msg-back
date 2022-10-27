<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function getAllUsers()
    {
        return User::all();
    }

    public function getUser($id)
    {
        return User::where('id', $id)->first();
    }


    public function updateUser(Request $request)
    {
        $request->validate([
            'name' => 'string|max:255',
            'email' => 'string|email|max:255|unique:users',
            'password' => 'string|min:6',
        ]);

        User::where('id', $request->id)->update([
            'name' => $request->name,
            'email' => $request->name,
            'password' => Hash::make($request->password)
        ]);
    }

    public function removeUser($id)
    {
        User::where('id', $id)->delete();
    }

    public function addAdmin($id)
    {
        User::where('id', $id)->update([
            'admin' => true,
        ]);
    }

    public function removeAdmin($id)
    {
        User::where('id', $id)->update([
            'admin' => false,
        ]);
    }
}
