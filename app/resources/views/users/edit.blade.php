@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            プロフィール編集
        </div>
        <div class="card-body">

            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('users.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- 上段：ユーザー名とパスワード --}}
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">新ユーザー名</label>
                        <input type="text" name="name" id="name" class="form-control"
                            value="{{ old('name', $user->name) }}">
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="password" class="form-label">新パスワード</label>
                        <input type="password" name="password" id="password" class="form-control">
                        @error('password')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- 下段：アイコンとパスワード確認 --}}
                <div class="row mb-3 align-items-end">
                    <div class="col-md-6">
                        <label for="icon" class="form-label">変更後アイコン</label>
                        <input type="file" name="icon" id="icon" class="form-control" onchange="previewImage(event)">
                        @error('icon')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror

                        {{-- プレビュー --}}
                        <div class="mt-2">
                            <img id="image-preview"
                                src="{{ $user->icon_path ? asset($user->icon_path) : '' }}"
                                alt="画像プレビュー"
                                style="width:150px; height:150px; object-fit:cover; display:{{ $user->icon_path ? 'block' : 'none' }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="password_confirmation" class="form-label">新パスワード確認</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                    </div>
                </div>

                {{-- 更新ボタン --}}
                <div class="row">
                    <div class="col d-flex justify-content-end">
                        <button type="submit" class="btn btn-success">更新</button>
                    </div>
                    <a href="{{ route('users.show') }}" class="btn btn-secondary">
                        戻る
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    function previewImage(event) {
        const preview = document.getElementById('image-preview');
        const file = event.target.files[0];
        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        } else {
            preview.src = '';
            preview.style.display = 'none';
        }
    }
</script>
@endsection