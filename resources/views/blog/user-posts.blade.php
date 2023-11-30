@extends('layouts.app')
@include('inc.navbar')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 pt-2">
                <a href="/blog" class="btn btn-outline-primary btn-sm">Go back</a>
                 <div class="row">
                    <div class="col-8">
                        <h1 class="display-one">Your Posts</h1>
                        <p>Click on a post to edit!</p>
                    </div>
                </div>      

                <div class="d-flex row row-cols-2 g-3 justify-content-center">
                    @foreach($posts as $post)
                    <div class="card mx-5" style="width: 18rem;">
                        <img class="card-img-top" src="{{asset('images/'.$post->image)}}" height="200px" alt="Card image cap">
                        <div class="card-body">
                          <h5 class="card-title"><a href="{{route('blog.manage_post',$post->id)}}">{{ \Illuminate\Support\Str::limit(ucfirst($post->title),65,'...') }}</a></h5>
                          <p class="card-text">{{ \Illuminate\Support\Str::limit($post->body, 100,'...')}}.</p>
                          <a href="" class="btn btn-primary">Posted By {{$post->user->name}}</a>
                          @if($post->status == 'approved')
                          <p class="badge bg-success mt-1">Approved</p>
                          @endif
                          @if($post->status == 'unapproved')
                          <p class="badge bg-warning mt-1">Unapproved</p>
                          @endif
                        </div>
                    </div>
                @endforeach
                </div>          
            </div>
            {{$posts->links()}}    
        </div>
    </div>
@endsection