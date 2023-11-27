@extends('layouts.app')

@section('content')
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger">
                {{ $error }}
            </div>
        @endforeach
    @endif

    <div class="container mt-2">
        <a href="/blog" class="btn btn-outline-primary btn-sm">Go back</a>
    </div>
    <div class="container border mt-5">

        <h1 class="display-4">Edit Post</h1>
        <p>Edit and submit this form to update a post</p>

        <hr>
        {{-- @foreach ($posts as $post) --}}
            <form action="/blog/{{ $post->id }}/edit" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                    <div class="mb-3">
                        <label for="title">Post Title</label>
                        <input type="text" id="title" class="form-control" name="title"
                            value="{{ $post->title }}">
                        @if ($errors->has('title'))
                            <div class="error">{{ $errors->first('firstname') }}</div>
                        @endif
                        @error('title')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="body">Post Body</label>
                        <textarea id="body" class="form-control" name="body" placeholder="Enter Post Body" rows="5">{{ $post->body }}</textarea>
                        @error('body')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="image">Add Image</label>
                        <input type="file" class="form-control" name="image" />
                        @error('image')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                <div class="row mt-2">
                    <div class="control-group col-12 text-center">
                        <button type="submit" id="btn-submit" class="btn btn-primary">
                            Update Post
                        </button>
                    </div>
                </div>
            </form>
        {{-- @endforeach --}}
    </div>

@endsection
