@extends('layouts.dashboard')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h1>View post {{ $post->id }}</h1>
                    <a href="{{ route('admin.posts.index') }}" class="btn btn-info">All Posts</a>
                </div>
                {{-- Contenuti --}}
                <dl>
                    <dt>Title:</dt>
                    <dd>{{ $post->title }}</dd>
                    <dt>Slug:</dt>
                    <dd>{{ $post->slug }}</dd>
                    <dt>Category:</dt>
                    <dd>{{ $category->name }}</dd>
                    <dt>Content:</dt>
                    <dd>{{ $post->content }}</dd>
                </dl>
                <dl>
                    {{-- / Contenuti --}}

                    <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-outline-info">Edit</a>
                    <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" class="d-inline-block ">
                        @csrf
                        @method('DELETE')

                        <button class="btn btn-danger" onclick="return confirm('Are you sure you wanna delete the Post?');">
                            Delete
                        </button>
                    </form>
                </dl>

            </div>
        </div>
    </div>
@endsection
