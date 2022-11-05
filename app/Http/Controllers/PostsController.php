<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PostsController extends Controller
{
    public function index(Request $request)
    {
        $params = $request->validate([
            'per_page' => 'numeric|gt:0',
            'search' => 'string|nullable',
        ]);

        $perPage = $params['per_page'] ?? 10;

        $posts = (new Post())->latest();

        if ($request->has('search') && $params['search']) {
            $posts->where(function ($query) use ($params) {
                $query->where('title', 'like', "%" . $params['search'] . "%")
                    ->orWhere('content', 'like', "%" . $params['search'] . "%");
            });
        }

        return $posts->paginate($perPage);
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        $fields = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'category_id' => 'required|numeric|exists:App\Models\Category,id'
        ]);

        $user = $request->user();

        $post = $user->posts()->create([
            'title' => $fields['title'],
            'content' => $fields['content'],
            'category_id' => $fields['category_id'],
        ]);

        return response($post, 201);
    }

    public function show(Post $post)
    {
        return $post;
    }

    public function edit(Post $post)
    {
    }

    public function update(Request $request, Post $post)
    {
        Gate::authorize('update-post', [$post]);


        $fields = $request->validate([
            'title' => 'string|min:2',
            'content' => 'string|min:2',
            'category_id' => 'numeric|exists:App\Models\Category,id'
        ]);

        if ($request->has('title')) {
            $post->title = $fields['title'];
        }

        if ($request->has('content')) {
            $post->content = $fields['content'];
        }

        if ($request->has('category_id')) {
            $post->category_id = $fields['category_id'];
        }

        $post->save();

        return response($post, 200);
    }

    public function destroy(Post $post)
    {
        Gate::authorize('delete-post', [$post]);
        $post->delete();

        return response(['message' => 'Post deleted successfully'], 200);
    }
}
