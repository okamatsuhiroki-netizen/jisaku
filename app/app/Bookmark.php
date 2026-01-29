<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    // 一括代入を許可
    protected $fillable = [
        'user_id',
        'post_id',
    ];

    /**
     * ブックマークしたユーザー
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * ブックマークされた投稿
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
