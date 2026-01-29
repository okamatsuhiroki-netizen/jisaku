@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            新規投稿
        </div>
        <div class="card-body">

            <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-3">
                    {{-- 左側：文章 --}}
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="content" class="form-label">文章</label>
                            <textarea name="content" id="content" class="form-control" rows="6" placeholder="内容を入力">{{ old('content') }}</textarea>
                            @error('content')
                            <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- 右側：画像アップロード + プレビュー --}}
                    <div class="col-md-4 d-flex flex-column justify-content-between">
                        <div class="mb-3">
                            <label for="image" class="form-label">画像アップロード</label>
                            <input type="file" name="image" id="image" class="form-control" onchange="previewImage(event)">
                            @error('image')
                            <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- 画像プレビュー --}}
                        <div class="mt-2">
                            <img id="image-preview" src="" alt="画像プレビュー" class="img-fluid rounded"
                                style="width:100%; max-height:300px; object-fit:cover; display:none;">
                        </div>
                    </div>
                </div>

                {{-- 投稿ボタン --}}
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-success btn-lg px-5">
                        投稿する
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection
{{-- 画像プレビュー用スクリプト --}}
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
