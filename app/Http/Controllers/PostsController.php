<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function index(Request $request)
    {
        $params = $request->validate([
            'per_page' => 'numeric|gt:0',
            'search' => 'string|nullable',
        ]);

        $perPage = $params['per_page'] ?? 10;

        $posts = new Post();

        if ($request->has('search')) {
            $posts->where('title', 'like', "%" . $params['search'] . "%")->orWhere('content', 'like', "%" . $params['search'] . "%");
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
            'tags' => 'required|string',
            'category' => 'required|string'
        ]);

        $user = $request->user();

        $post = $user->posts()->create([
            'title' => $fields['title'],
            'content' => $fields['content'],
            'tags' => $fields['tags'],
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
    }

    public function destroy(Post $post)
    {
    }
}
