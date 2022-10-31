<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{
    public function index()
    {
        Gate::authorize('get-users');

        return User::all();
    }

    public function show(User $user)
    {
        return User::find($user->id);
    }

    public function me(Request $request)
    {
        return $request->user();
    }

    public function editMe(Request $request)
    {
        $fields = $request->validate([
            'name' => 'string',
            'avatar' => 'file|mimes:png,jpg,jpeg|max:3072|nullable'
        ]);

        $user = $request->user();

        if ($request->has('name')) {
            $user->name = $fields['name'];
        }

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('public/avatars');

            if ($user->avatar && Storage::exists($user->avatar)) {
                Storage::delete($user->avatar);
            }

            $user->avatar = $path;
        }

        $user->save();

        return response(['data' => $user], 200);
    }

    public function userPosts(Request $request)
    {
        $params = $request->validate([
            'per_page' => 'numeric|gt:0',
            'search' => 'string|nullable',
        ]);

        $perPage = $params['per_page'] ?? 10;

        $posts = (new Post())->latest()->where('author_id', $request->user()->id);

        if ($request->has('search') && $params['search']) {
            $posts->where(function ($query) use ($params) {
                $query->where('title', 'like', "%" . $params['search'] . "%")
                    ->orWhere('content', 'like', "%" . $params['search'] . "%");
            });
        }

        return $posts->paginate($perPage);
    }

    public function destroy(User $user)
    {
        Gate::authorize('delete-user', [$user]);
        $user->delete();

        return response(['message' => 'User deleted successfully'], 200);
    }
}
