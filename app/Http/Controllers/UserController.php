<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function getAllUsers()
    {
        return User::all();
    }

    public function getUser(Request $request)
    {
        return User::where('username', $request->username);
    }

    public function removeUser(Request $request)
    {
        User::where('email', $request->email)->delete();
    }

    public function addAdmin(Request $request)
    {
        User::where('id', $request->id)->update([
            'admin' => 1,
        ]);
    }

    public function removeAdmin(Request $request)
    {
        User::where('id', $request->id)->update([
            'admin' => 0,
        ]);
    }
}
