@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            登録編集
        </div>

        <div class="card-body">

            {{-- 成功メッセージ --}}
            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            {{-- メールアドレス変更 --}}
            <form method="POST" action="{{ route('users.account.update') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">登録メールアドレス</label>
                    <input type="email"
                        name="email"
                        class="form-control"
                        value="{{ old('email', auth()->user()->email) }}"
                        required>
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">
                        変更完了
                    </button>
                </div>
            </form>

            <hr>

            {{-- 退会 --}}
            <form method="POST"
                action="{{ route('users.destroy') }}"
                onsubmit="return confirm('本当に退会しますか？');">
                @csrf
                @method('DELETE')

                <button type="submit" class="btn btn-danger">
                    退会する
                </button>
            </form>
        </div>

        <a href="{{ route('users.show') }}" class="btn btn-secondary">
            戻る
        </a>
    </div>
</div>
@endsection