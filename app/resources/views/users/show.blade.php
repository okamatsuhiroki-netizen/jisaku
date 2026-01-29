@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            マイページ
        </div>

        <div class="card-body">
            <div class="row align-items-center">

                {{-- 左：ユーザー情報 --}}
                <div class="col-md-4 mb-3 mb-md-0">
                    <h4>{{ $user->name }}</h4>
                    <p class="mb-0">{{ $user->email }}</p>
                </div>

                {{-- 中央：アイコン --}}
                <div class="col-md-4 text-center mb-3 mb-md-0">
                    <img
                        src="{{ $user->icon_path ? asset($user->icon_path) : asset('images/default_icon.png') }}"
                        class="rounded-circle"
                        style="width:80px; height:80px; object-fit:cover;">
                </div>

                {{-- 右列：ボタン --}}
                <div class="col-md-4 d-flex flex-column align-items-end">

                    {{-- 上段：プロフィール編集 + ブックマーク --}}
                    <div class="d-flex justify-content-between align-items-center mb-2" style="width: 70%;">
                        <a href="{{ route('users.edit') }}" class="btn btn-primary btn-sm">
                            プロフィール編集
                        </a>
                        <a href="{{ route('bookmarks.index') }}" class="btn btn-primary btn-sm">
                            ブックマーク
                        </a>
                    </div>

                    {{-- 下段：登録編集（右端に揃える） --}}
                    <div class="text-end" style="width: 70%;">
                        <a href="{{ route('users.account.edit') }}" class="btn btn-primary btn-sm">
                            登録編集
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 自分の投稿一覧 --}}
    <div class="mt-4">
        <h5>過去の投稿一覧</h5>

        @if($user->posts->count() > 0)
        <div class="list-group">
            @foreach($user->posts as $post)
            <div class="list-group-item d-flex justify-content-between align-items-start">

                {{-- 投稿内容 --}}
                <div>
                    <p class="mb-1">{{ $post->content }}</p>
                    <small class="text-muted">
                        投稿日: {{ $post->created_at->format('Y-m-d H:i') }}
                    </small>
                </div>

                {{-- ボタン群 --}}
                <div class="d-flex gap-2">
                    {{-- 投稿詳細ボタン --}}
                    <a href="{{ route('posts.show', $post->id) }}"
                        class="btn btn-outline-primary btn-sm">
                        詳細
                    </a>

                    {{-- 削除ボタン --}}
                    <form action="{{ route('posts.destroy', $post->id) }}"
                        method="POST"
                        onsubmit="return confirm('本当に削除しますか？');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            削除
                        </button>
                    </form>
                </div>

            </div>
            @endforeach
        </div>
        @else
        <p>まだ投稿はありません。</p>
        @endif
    </div>
</div>
@endsection