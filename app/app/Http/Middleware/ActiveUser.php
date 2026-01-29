<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ActiveUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // ログインしていない場合は auth ミドルウェアに任せる
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // 管理者は無条件で通す
        if ($user->isAdmin()) {
            return $next($request);
        }

        // 利用停止中ユーザーは /suspended へリダイレクト
        if (!$user->is_active) {

            // すでに /suspended ページにいる場合はループ防止
            if ($request->routeIs('users.suspended')) {
                return $next($request);
            }

            return redirect()->route('users.suspended');
        }

        // 通常ユーザーはそのままリクエストを通す
        return $next($request);
    }
}
