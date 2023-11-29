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

        <h1 class="display-4">Create a New Post</h1>
        <p>Fill and submit this form to create a post</p>

        <hr>

        <form action="{{ route('blog.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="title">Post Title</label>
                <input type="text" id="title" class="form-control" name="title" placeholder="Enter Post Title"
                    value="{{ old('title') }}">
                @if(session('response'))
                    {!! session()->get('response') !!}
                @endif
                @error('title')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="body">Post Body</label>
                <textarea id="body" class="form-control" name="body" placeholder="Enter Post Body" rows="">{{ old('body') }}</textarea>
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
                        Add Post
                    </button>
                </div>
            </div>
        </form>
    </div>

@endsection
