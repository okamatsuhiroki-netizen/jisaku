<?php

namespace App\Http\Controllers;

use App\Bookmark;
use App\Post;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    /**
     * ブックマーク一覧
     */
    public function index()
    {
        $bookmarks = Bookmark::with('post.user')
            ->where('user_id', auth()->id())
            ->get();

        return view('bookmarks.index', compact('bookmarks'));
    }

    /**
     * ブックマーク ON / OFF
     */
    public function toggle(Post $post)
    {
        $user = auth()->user();

        $bookmark = $post->bookmarks()
            ->where('user_id', $user->id)
            ->first();

        if ($bookmark) {
            // 解除
            $bookmark->delete();
            $status = 'removed';
        } else {
            // 登録
            $post->bookmarks()->create([
                'user_id' => $user->id,
            ]);
            $status = 'added';
        }

        return response()->json([
            'status' => $status,
            'count'  => $post->bookmarks()->count(),
        ]);
    }
}
