@extends('layouts.app')

@section('content')
<div class="container py-5 text-center">
    <h2 class="text-danger mb-4">アカウント利用停止中</h2>

    <p>
        現在このアカウントは管理者により<br>
        <strong>利用停止</strong>されています。
    </p>

    <p class="mt-3">
        詳細については運営までお問い合わせください。
    </p>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="btn btn-secondary mt-4">
            ログアウト
        </button>
    </form>
</div>
@endsection
