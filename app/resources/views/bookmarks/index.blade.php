@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            ブックマーク一覧
        </div>

        <div class="card-body">
            @if($bookmarks->isEmpty())
            <p class="mb-0">ブックマークはありません。</p>
            @else
            <ul class="list-group">
                @foreach($bookmarks as $bookmark)
                <li class="list-group-item">
                    <a href="{{ route('posts.show', ['post' => $bookmark->post, 'from' => 'bookmarks']) }}"
                        class="text-decoration-none text-dark">

                        <div class="fw-bold">
                            {{ $bookmark->post->user->name }}
                        </div>

                        <div class="text-muted small">
                            {{ $bookmark->post->created_at->format('Y-m-d') }}
                        </div>

                        <div class="mt-1">
                            {{ Str::limit($bookmark->post->content, 50) }}
                        </div>

                    </a>
                </li>
                @endforeach
            </ul>
            @endif
        </div>
    </div>

    <div class="row mb-3">
        <div class="col text-end"> <a href="{{ route('users.show') }}" class="btn btn-secondary"> マイページに戻る </a> </div>
    </div>
</div>
@endsection