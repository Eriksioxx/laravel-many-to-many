@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                {{-- Title card --}}
                <div class="card">
                    <div class="card-header">Write a new Post</div>

                    {{-- / Title card --}}
                    <div class="card-body">
                        <form action="{{ route('admin.posts.store') }}" method="POST">
                            {{-- Token --}}
                            @csrf
                            {{-- / Token --}}

                            {{-- title post --}}
                            <div class="form-group">
                                <label for="title">Title:</label>
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror "
                                    placeholder="Post's title" value="{{ old('title') }}" required>
                                @error('title')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            {{-- / title post --}}

                            {{-- Category --}}
                            <div class="form-group">
                                <label for="title">Category:</label>
                                <select name="category_id">
                                    <option value="">--Choose category--</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ $category->id == old('category_id') ? 'selected' : '' }}>
                                            {{ $category->name }} </option>
                                    @endforeach
                                </select>

                                @error('title')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            {{-- / Category --}}

                            {{-- Tags --}}
                            <div class="form-group ps-4">
                                <h2 for="title">Tags:</h2>
                                @foreach ($tags as $tag)
                                    <input class="form-check-input ms-4" type="checkbox" value="{{ $tag->id }}"
                                        name="tags[]" />
                                    {{-- {{ $tags->id, in_array(old('tags[]', [])) ? 'checked' : '' }} --}}
                                    <div class="form-check-label">{{ $tag->name }}</div>
                                @endforeach

                                @error('tags[]')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            {{-- / Tags --}}

                            {{-- content post --}}
                            <div class="form-group">
                                <label for="content">Content:</label>
                                <textarea type="text" name="content" class="form-control @error('content') is-invalid @enderror"
                                    placeholder="Post's content">

                        </textarea>
                                @error('content')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            {{-- / content post --}}

                            <div class="form-group">
                                <input type="submit" class="btn btn-info white" value="Create Post">
                            </div>
                        </form>
                    </div>
                </div>
                <a href="{{ route('admin.posts.index') }}" class="btn btn-success"> Back</a>

            </div>
        </div>
    </div>
@endsection
