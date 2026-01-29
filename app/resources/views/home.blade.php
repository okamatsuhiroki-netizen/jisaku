@extends('layouts.app')

@section('content')
<div class="container py-4">

    {{-- 🔍 検索フォーム --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <div class="row g-2 align-items-center">
                <form method="GET" action="{{ route('home') }}" class="row g-2 align-items-center">

                    {{-- ユーザー名・文章 --}}
                    <div class="col-auto flex-grow-1">
                        <input type="text" name="keyword" class="form-control" placeholder="ユーザー名、文章"
                            value="{{ request('keyword') }}">
                    </div>

                    {{-- 投稿日 --}}
                    <div class="col-auto">
                        <input type="date" name="date" class="form-control" value="{{ request('date') }}">
                    </div>

                    {{-- 検索ボタン --}}
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary w-100">検索</button>
                    </div>
                </form>
                {{-- マイページボタン --}}
                <div class="col-auto">
                    <a href="{{ route('users.show') }}" class="btn btn-secondary w-100">マイページ</a>
                </div>

                {{-- 新規投稿ボタン --}}
                <div class="col-auto">
                    <a href="{{ route('posts.create') }}" class="btn btn-success w-100">新規投稿</a>
                </div>
            </div>
        </div>
    </div>

    {{-- 📝 投稿一覧 --}}
    @forelse ($posts as $post)
    <div class="card mb-4 shadow-sm">
        <div class="card-body">

            {{-- 投稿者 --}}
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="mb-0 fw-bold">{{ $post->user->name }}</h6>
                <small class="text-muted">{{ $post->created_at->format('Y/m/d H:i') }}</small>
            </div>

            {{-- 投稿内容 --}}
            <p class="mb-3">{{ $post->content }}</p>

            {{-- 画像 --}}
            @if($post->image_path)
            <div class="mb-3 text-center">
                <img src="{{ asset($post->image_path) }}" class="img-fluid rounded" style="max-height: 300px;">
            </div>
            @endif

            {{-- コメント・ブックマーク --}}
            <div class="d-flex gap-3 mb-2">
                <span class="badge bg-info text-dark">💬 {{ $post->comments->count() }}</span>
                <span
                    class="badge bg-warning text-dark bookmark-count"
                    data-post-id="{{ $post->id }}">
                    🔖 {{ $post->bookmarks->count() }}
                </span>
            </div>

            <div class="d-flex gap-2">
                {{-- 詳細リンク --}}
                <a href="{{ route('posts.show', ['post' => $post, 'from' => 'index']) }}"
                    class="btn btn-outline-primary btn-sm">
                    詳細を見る
                </a>

                {{-- ブックマーク --}}
                @auth
                <button
                    type="button"
                    class="btn btn-sm bookmark-btn
{{ $post->bookmarks->where('user_id', auth()->id())->count()
    ? 'btn-danger'
    : 'btn-outline-danger' }}"
                    data-post-id="{{ $post->id }}">
                    ❤
                </button>
                @endauth


            </div>
        </div>
    </div>
    @empty
    <div class="alert alert-secondary text-center">
        まだ投稿はありません。
    </div>
    @endforelse

    {{-- 📄 ページネーション --}}
    <div class="d-flex justify-content-center mt-4">
        {{ $posts->links() }}
    </div>
</div>

<script>
    document.querySelectorAll('.bookmark-btn').forEach(button => {
        button.addEventListener('click', function() {

            const postId = this.dataset.postId;
            const countBadge = document.querySelector(
                `.bookmark-count[data-post-id="${postId}"]`
            );

            fetch(`/posts/${postId}/bookmark`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'added') {
                        this.classList.remove('btn-outline-danger');
                        this.classList.add('btn-danger');
                    }

                    if (data.status === 'removed') {
                        this.classList.remove('btn-danger');
                        this.classList.add('btn-outline-danger');
                    }

                    // ★ ブックマーク数を更新
                    if (countBadge) {
                        countBadge.textContent = `🔖 ${data.count}`;
                    }
                })
                .catch(() => {
                    alert('通信エラーが発生しました');
                });
        });
    });
</script>
@endsection