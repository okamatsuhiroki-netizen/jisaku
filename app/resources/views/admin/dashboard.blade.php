@extends('admin.layout')

@section('content')
<div class="container py-4 text-light">
    <h1 class="mb-2 fw-bold text-white">管理者ダッシュボード</h1>
    <p class="text-secondary mb-4">ここは管理者専用ページです。</p>

    <div class="row">
        {{-- ユーザー一覧 --}}
        <div class="col-md-6 mb-4">
            <div class="card admin-card bg-dark text-light border-0 shadow-sm">
                <div class="card-body text-center py-4">
                    <h5 class="card-title text-white mb-3">ユーザー管理</h5>
                    <p class="card-text text-secondary mb-4">
                        登録ユーザーの一覧・編集・利用停止
                    </p>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary px-4">
                        ユーザー一覧へ
                    </a>
                </div>
            </div>
        </div>

        {{-- 投稿一覧 --}}
        <div class="col-md-6 mb-4">
            <div class="card admin-card bg-dark text-light border-0 shadow-sm">
                <div class="card-body text-center py-4">
                    <h5 class="card-title text-white mb-3">投稿管理</h5>
                    <p class="card-text text-secondary mb-4">
                        投稿の確認・削除・非表示
                    </p>
                    <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-danger px-4">
                        投稿一覧へ
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection