<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Post;
use App\Report;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'icon_path',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | リレーション
    |--------------------------------------------------------------------------
    */

    // 投稿
    public function posts()
    {
        return $this->hasMany(Post::class)
        ->where('is_hidden', 0)
        ->latest();
        return $this->hasMany(Post::class);
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

    /**
     * ⭐ 自分の投稿についた違反報告
     */
    public function reportedPosts()
    {
        return $this->hasManyThrough(
            Report::class, // 最終的に数えたいモデル
            Post::class,   // 中間モデル
            'user_id',     // posts.user_id
            'post_id',     // reports.post_id
            'id',          // users.id
            'id'           // posts.id
        );
    }

    /*
    |--------------------------------------------------------------------------
    | 権限関連
    |--------------------------------------------------------------------------
    */

    const ROLE_USER  = 0;
    const ROLE_ADMIN = 1;

    /**
     * 管理者かどうか
     */
    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    /**
     * 利用停止中かどうか
     */
    public function isActive()
    {
        return $this->is_active;
    }
}
