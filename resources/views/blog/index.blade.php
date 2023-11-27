@extends('layouts.app')
@include('inc.navbar')
@section('content')
<?php  
$postResponse = $posts->getData();
// dd($postResponse->data[0]->user->name);
$count = count($postResponse->data);
$post = $postResponse->data;
?>
    <div class="container">
        <div class="row">
            <div class="col-12 pt-2">
                 <div class="row">
                    <div class="col-8">
                        <h1 class="display-one">Our Blog!</h1>
                        <p>Enjoy reading our posts. Click on a post to read!</p>
                    </div>
                </div>      
  
                <div class="d-flex row row-cols-2 g-3 justify-content-center">
                    @for($i=0;$i<$count;$i++)
                    <div class="card mx-5" style="width: 18rem;">
                        <img class="card-img-top" src="{{asset('images/'.$post[$i]->image)}}" height="200px" alt="Card image cap">
                        <div class="card-body">
                          <h5 class="card-title"><a href="/blog/{{ $post[$i]->id }}">{{ \Illuminate\Support\Str::limit(ucfirst($post[$i]->title),65,'...') }}</a></h5>
                          <p class="card-text">{{ \Illuminate\Support\Str::limit($post[$i]->body, 100,'...')}}.</p>
                          <a href="#" class="btn btn-primary">Posted By {{$post[$i]->user->name}}</a>
                        </div>
                    </div>
                    @endfor  
                </div>        
            </div>
        </div>
    </div>
@endsection