<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Report;

class Post extends Model
{
    protected $fillable = [
        'user_id','content', 'image_path', 'is_hidden',
    ];

    // 投稿者
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // コメント
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // ブックマーク
    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    // ⭐ 違反報告（ここに追加）
    public function reports()
    {
        return $this->hasMany(Report::class);
    }
}
