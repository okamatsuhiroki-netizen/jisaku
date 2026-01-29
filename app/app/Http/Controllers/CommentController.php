<?php

namespace App\Http\Controllers;

use App\Post;
use App\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * コメント詳細画面
     */
    public function show(Post $post)
    {
        $post->load(['user', 'comments.user']);

        return view('comments.show', compact('post'));
    }

    /**
     * コメント投稿
     */
    public function store(Request $request, Post $post)
    {
        $request->validate(
            [
                'comment' => 'required|string|max:500',
            ],
            [
                'comment.required' => 'コメントを入力してください。',
                'comment.max' => 'コメントは500文字以内で入力してください。',
            ]
        );

        Comment::create([
            'post_id' => $post->id,
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]); 
       
            // 例: reportsテーブルに保存
            // $comment->reports()->create([
            //     'user_id' => $request->user()->id,
            //     'reason' => '不適切なコメント', // 今回は簡単に固定
            // ]);

            return back()->with('success', 'コメントを報告しました');


        // コメント詳細画面へ戻す
        return redirect()
            ->route('comments.show', $post)
            ->with('success', 'コメントを投稿しました');
    }
}
