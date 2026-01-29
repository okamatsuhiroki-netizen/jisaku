@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            投稿詳細
        </div>

        <div class="card-body">

            {{-- 投稿者 --}}
            <h5>投稿者: {{ $post->user->name }}</h5>

            {{-- 投稿内容 --}}
            <p>{{ $post->content }}</p>

            {{-- 画像 --}}
            @if($post->image_path)
            <img src="{{ asset($post->image_path) }}" class="img-fluid mb-2" style="max-height:400px; object-fit:cover;">
            @endif

            {{-- コメント・ブックマーク --}}
            <div class="d-flex gap-3 mt-2">
                <span>💬 コメント: {{ $post->comments->count() }}</span>
                <span>🔖 ブックマーク: {{ $post->bookmarks->count() }}</span>
            </div>

            {{-- 🔽 コメント詳細へボタン --}}
            <div class="mt-3 d-flex justify-content-end gap-2">

                <a href="{{ route('comments.show', $post) }}"
                    class="btn btn-outline-primary btn-sm">
                    コメント詳細を見る
                </a>

                @auth
                @if ($post->user_id !== auth()->id())
                <form method="POST"
                    action="{{ route('posts.report', $post->id) }}"
                    onsubmit="return confirm('この投稿を違反報告しますか？');">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm">
                        違反報告
                    </button>
                </form>
                @endif
                @endauth

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

                <span class="bookmark-count ms-1" data-post-id="{{ $post->id }}">
                    {{ $post->bookmarks->count() }}
                </span>
                @endauth


                @if(auth()->id() === $post->user_id)
                <a href="{{ route('posts.edit', $post) }}"
                    class="btn btn-warning btn-sm">
                    編集
                </a>
                @endif

            </div>

            {{-- コメント一覧 --}}
            @if($post->comments->count() > 0)
            <div class="mt-3">
                <h6>コメント一覧</h6>
                <ul class="list-group">
                    @foreach($post->comments as $comment)
                    <li class="list-group-item">
                        <strong>{{ $comment->user->name }}:</strong> {{ $comment->content }}
                        <small class="text-muted d-block">投稿日: {{ $comment->created_at->format('Y/m/d H:i') }}</small>
                    </li>
                    @endforeach
                </ul>
            </div>
            @auth
            @endauth

            @else
            <p class="mt-3">コメントはまだありません。</p>
            @endif

        </div>
    </div>

    {{-- 戻るボタン --}}
    <div class="mt-3">
        @if(request('from') === 'bookmarks')
        <a href="{{ route('bookmarks.index') }}" class="btn btn-secondary">戻る</a>
        @else
        <a href="{{ route('posts.index') }}" class="btn btn-secondary">戻る</a>
        @endif
    </div>
</div>
<script>
document.querySelectorAll('.bookmark-btn').forEach(button => {
    button.addEventListener('click', function () {

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
        .then(res => res.json())
        .then(data => {
            this.classList.toggle('btn-danger', data.status === 'added');
            this.classList.toggle('btn-outline-danger', data.status === 'removed');

            if (countBadge) {
                countBadge.textContent = data.count;
            }
        });
    });
});
</script>
@endsection