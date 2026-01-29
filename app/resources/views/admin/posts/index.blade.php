@extends('admin.layout')

@section('content')
<div class="container-fluid px-5"> {{-- 画面いっぱい＋左右余白 --}}
    <h1 class="mb-4">投稿一覧</h1>

    @if(session('success'))
    <p class="text-success">{{ session('success') }}</p>
    @endif

    <div class="card admin-card">
        <div class="card-body">

            <table class="table table-dark table-hover align-middle mb-0 w-100">
                <thead>
                    <tr>
                        <th style="width: 5%">ID</th>
                        <th style="width: 15%">投稿者</th>
                        <th>内容</th>
                        <th style="width: 10%">状態</th>
                        <th style="width: 10%">操作</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($posts as $post)
                    <tr>
                        <td>{{ $post->id }}</td>
                        <td>{{ $post->user->name }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($post->content, 80) }}</td>
                        <td>
                            @if($post->is_hidden)
                            <span class="text-danger">非表示</span>
                            @else
                            <span class="text-success">表示中</span>
                            @endif
                        </td>
                        <td>
                            <form method="POST"
                                action="{{ route('admin.posts.destroy', $post) }}"
                                class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="btn btn-sm btn-danger"
                                    onclick="return confirm('本当に削除しますか？')">
                                    削除
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $posts->links() }}
        </div>
    </div>
    {{-- ページネーション --}}
    <div class="mt-4 d-flex justify-content-center">
        {{ $posts->links() }}
    </div>

    {{-- 戻るボタン（下） --}}
    <div class="mt-4 text-center">
        <a href="{{ route('admin.dashboard') }}"
            class="btn btn-outline-light">
            ダッシュボードへ戻る
        </a>
    </div>
    @endsection