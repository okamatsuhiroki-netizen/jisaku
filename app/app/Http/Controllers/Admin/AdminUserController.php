<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::withCount([
            'posts',
            'reportedPosts',
        ])
            ->latest()
            ->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    /**
     * ⭐ 利用停止／解除 切替
     */
    public function toggleActive(User $user)
    {
        // 管理者は停止不可
        if ($user->isAdmin()) {
            return back()->with('error', '管理者は停止できません');
        }

        $user->update([
            'is_active' => !$user->is_active,
        ]);

        $message = $user->is_active
            ? 'ユーザーを有効化しました'
            : 'ユーザーを利用停止にしました';

        return back()->with('success', $message);
    }
}
