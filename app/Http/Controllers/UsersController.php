<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UsersController extends Controller
{
    public function index()
    {
        return User::with('roles:id,name')->get();
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
            $domain = $request->getSchemeAndHttpHost();
            $currentAvatarPublicUrl = Str::replace($domain . '/storage', 'public', $user->avatar);

            if (Storage::exists($currentAvatarPublicUrl)) {
                Storage::delete($currentAvatarPublicUrl);
            }

            $user->avatar = $domain . Storage::url($path);
        }

        $user->save();

        return response(['data' => $user], 200);
    }

    public function userPosts(Request $request)
    {
        $user = $request->user();
        return $user->posts;
    }

    public function destroy(User $user)
    {
        Gate::authorize('delete-user', [$user]);
        $user->delete();

        return response(['message' => 'User deleted successfully'], 200);
    }
}
