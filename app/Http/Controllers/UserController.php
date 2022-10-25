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

    public function getUser($id)
    {
        return User::where('id', $id)->first();
    }

    public function removeUser($id)
    {
        User::where('id', $id)->delete();
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
