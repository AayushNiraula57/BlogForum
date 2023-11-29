@extends('layouts.app')
@section('content')
@if (session('message'))
    <div class="alert">{{ session('message') }}</div>
@endif
    <div class="container">
        <div class="row">
            <div class="col-12 pt-2">
                <a href="/blog" class="btn btn-outline-primary btn-sm">Go back</a>
                <h1 class="display-one">{{ ucfirst($post->title) }}</h1>
                <img src="{{asset('images/'.$post->image)}}" class="img-fluid" alt="Title image">
                <p>{!! $post->body !!}</p> 
                <hr>
                @auth
                <a href="/blog/{{ $post->id }}/edit" class="btn btn-outline-primary">Edit Post</a>
                <br><br>
                <form id="delete-frm" class="" action="{{route('blog.destroy',$post->id)}}" method="POST">
                    @method('DELETE')
                    @csrf
                    <button class="btn btn-danger">Delete Post</button>
                </form>
                @endauth
            </div>
        </div>
    </div>
@endsection