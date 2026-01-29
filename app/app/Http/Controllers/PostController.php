<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use App\Report;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * ミドルウェア設定
     */
    public function __construct()
    {
        // ログイン済み & 利用中ユーザーのみ
        $this->middleware(['auth', 'active'])->except(['index', 'show']);
    }

    /**
     * 投稿一覧
     */
    public function index()
    {
        $posts = Post::with(['user', 'comments', 'bookmarks'])
            ->where('is_hidden', 0)
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('home', compact('posts'));
    }

    /**
     * 新規投稿画面
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * 投稿保存
     */
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|max:500',
            'image'   => 'nullable|image|max:2048',
        ]);

        $post = new Post();
        $post->user_id = auth()->id();
        $post->content = $request->content;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('posts', 'public');
            $post->image_path = 'storage/' . $path;
        }

        $post->save();

        return redirect()->route('home')->with('success', '投稿しました');
    }

    /**
     * 投稿詳細
     */
    public function show(Post $post)
    {
        $post->load(['user', 'comments', 'bookmarks']);
        return view('posts.show', compact('post'));
    }

    /**
     * 投稿編集画面（自分の投稿のみ）
     */
    public function edit(Post $post)
    {
        $this->authorizePostOwner($post);

        return view('posts.edit', compact('post'));
    }

    /**
     * 投稿更新（自分の投稿のみ）
     */
    public function update(Request $request, Post $post)
    {
        $this->authorizePostOwner($post);

        $request->validate([
            'content' => 'required|max:500',
            'image'   => 'nullable|image|max:2048',
        ]);

        $data = ['content' => $request->content];

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('posts', 'public');
            $data['image_path'] = 'storage/' . $path;
        }

        $post->update($data);

        return redirect()->route('posts.show', $post)
            ->with('success', '投稿を更新しました');
    }

    /**
     * 投稿削除（自分の投稿のみ）
     */
    public function destroy(Post $post)
    {
        $this->authorizePostOwner($post);

        $post->delete();

        return redirect()->route('users.show')
            ->with('success', '投稿を削除しました');
    }

    /**
     * 投稿の違反報告
     */
    public function report(Post $post)
    {
        $user = Auth::user();

        if (!$user) {
            abort(403);
        }

        if ($post->user_id === $user->id) {
            return back()->with('error', '自分の投稿は報告できません');
        }

        $alreadyReported = Report::where('user_id', $user->id)
            ->where('post_id', $post->id)
            ->exists();

        if ($alreadyReported) {
            return back()->with('error', 'すでに報告済みです');
        }

        Report::create([
            'user_id' => $user->id,
            'post_id' => $post->id,
            'reason'  => '不適切な投稿',
        ]);

        return back()->with('success', '違反報告を送信しました');
    }

    /**
     * 投稿オーナー確認
     */
    private function authorizePostOwner(Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            abort(403, '権限がありません');
        }
    }
}
