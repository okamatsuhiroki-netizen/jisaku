<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        // 未ログイン or 管理者でない
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, '管理者のみアクセス可能です');
        }

        return $next($request);
    }
}

