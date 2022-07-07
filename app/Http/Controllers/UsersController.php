<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function show(User $user)
    {
        return User::find($user->id);
    }

    public function userPosts(Request $request) {
        $user = $request->user();
        return $user->posts;
    }
}
