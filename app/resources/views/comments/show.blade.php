@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            コメント詳細
        </div>

        <div class="card-body">
            <h5>投稿者：{{ $post->user->name }}</h5>
            <p>{{ $post->content }}</p>

            <hr>

            {{-- コメント投稿 --}}
            @auth
            <form method="POST" action="{{ route('posts.comment', $post->id) }}">
                @csrf

                <textarea
                    name="content"
                    class="form-control mb-2 @error('content') is-invalid @enderror"
                    rows="3"
                    placeholder="コメントを入力">{{ old('content') }}</textarea>

                @error('content')
                <div class="text-danger mb-2">{{ $message }}</div>
                @enderror

                <button class="btn btn-primary btn-sm">投稿</button>
            </form>
            @endauth

            <hr>

            {{-- コメント一覧 --}}
            <h6>コメント一覧</h6>
            @forelse($post->comments as $comment)
            <div class="border rounded p-2 mb-2">
                <strong>{{ $comment->user->name }}</strong>
                <p class="mb-1">{{ $comment->content }}</p>
                <small class="text-muted">
                    {{ $comment->created_at->format('Y/m/d H:i') }}
                </small>
            </div>
            @empty
            <p>コメントはありません</p>
            @endforelse
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('posts.show', $post) }}"
            class="btn btn-secondary btn-sm">
            投稿詳細に戻る
        </a>
    </div>
</div>
@endsection