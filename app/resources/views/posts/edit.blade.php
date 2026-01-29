@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            投稿編集
        </div>

        <div class="card-body">

            <form method="POST"
                action="{{ route('posts.update', $post) }}"
                enctype="multipart/form-data"
                novalidate>
                @csrf
                @method('PUT')

                {{-- 本文 --}}
                <div class="mb-3">
                    <label class="form-label">投稿内容</label>
                    <textarea name="content"
                        class="form-control @error('content') is-invalid @enderror"
                        rows="5">{{ old('content', $post->content) }}</textarea>

                    @error('content')
                    <div class="text-danger small mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                {{-- 現在の画像 --}}
                @if ($post->image_path)
                <div class="mb-3">
                    <label class="form-label">現在の画像</label><br>
                    <img src="{{ asset($post->image_path) }}"
                        class="img-fluid mb-2"
                        style="max-height:200px;">
                </div>
                @endif

                {{-- 画像変更 --}}
                <div class="mb-3">
                    <label class="form-label">画像を変更</label>
                    <input type="file"
                        name="image"
                        class="form-control @error('image') is-invalid @enderror">

                    @error('image')
                    <div class="text-danger small mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('posts.show', $post) }}"
                        class="btn btn-secondary">
                        戻る
                    </a>

                    <button type="submit"
                        class="btn btn-primary"
                        formnovalidate>
                        更新する
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection