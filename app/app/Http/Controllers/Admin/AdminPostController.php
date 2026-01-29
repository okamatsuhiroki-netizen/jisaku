<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Post;

class AdminPostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')->withCount('reports')->latest()->paginate(20);
        return view('admin.posts.index', compact('posts'));
    }

    public function destroy(Post $post)
{
    $post->update([
        'is_hidden' => 1,
    ]);

    return back()->with('success', '投稿を非表示にしました');
}

}
