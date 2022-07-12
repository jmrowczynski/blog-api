<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Mockery\Exception;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PostsController extends Controller
{
    public function index(Request $request)
    {
        $params = $request->validate([
            'per_page' => 'numeric|gt:0',
            'search' => 'string|nullable',
        ]);

        $perPage = $params['per_page'] ?? 10;

        $posts = (new Post)->newQuery()->with('user');

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
    }

    public function show(Request $request)
    {

        $post = Post::where('slug', '=', $request['slug'])->first();

        if ($post) return $post;

        abort(404, 'Post not found');
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
