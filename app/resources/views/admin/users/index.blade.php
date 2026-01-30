@extends('admin.layout')

@section('content')
<div class="container-fluid px-5">
    <h1 class="mb-4">ユーザー一覧</h1>

    <div class="card admin-card">
        <div class="card-body">

            <table class="table table-dark table-hover align-middle mb-0 w-100">
                <thead>
                    <tr>
                        <th style="width: 30%">名前</th>
                        <th style="width: 15%">投稿数</th>
                        <th style="width: 20%">違反報告数</th>
                        <th style="width: 15%">利用停止</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>

                        {{-- 投稿数 --}}
                        <td>{{ $user->posts->count() }}</td>

                        {{-- 違反報告数 --}}
                        <td>
                            @if($user->reported_posts_count > 0)
                            <span class="text-warning fw-bold">
                                {{ $user->reported_posts_count }}
                            </span>
                            @else
                            <span class="text-muted">0</span>
                            @endif
                        </td>

                        {{-- 利用停止ボタン --}}
                        <td>
                            <form action="{{ route('admin.users.toggleActive', $user) }}"
                                method="POST"
                                class="d-inline">
                                @csrf

                                @if($user->is_active)
                                <button type="submit"
                                    class="btn btn-sm btn-danger">
                                    停止
                                </button>
                                @else
                                <button type="submit"
                                    class="btn btn-sm btn-success">
                                    削除
                                </button>
                                @endif
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

    </div>
    {{-- ページネーション --}}
    <div class="mt-4 d-flex justify-content-center">
        {{ $users->links() }}
    </div>

    {{-- 戻るボタン --}}
    <div class="mt-4 text-center">
        <a href="{{ route('admin.dashboard') }}"
            class="btn btn-outline-light">
            ダッシュボードへ戻る
        </a>
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $users->links() }}
    </div>
</div>
@endsection