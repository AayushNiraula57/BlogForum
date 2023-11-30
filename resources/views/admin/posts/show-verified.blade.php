@extends('admin.layouts.layout')
@include('admin.inc.navbar')
@section('title','Approved Posts')
@section('content')
<?php 
$sn=1;
?>
<div class="container">
    <h4>Verified Posts</h4>
    <table class="table">
        <thead>
          <tr>
            <th scope="col">S.N.</th>
            <th scope="col">Image</th>
            <th scope="col">Blog</th>
            <th scope="col">Status</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
      @foreach($posts as $post)
      <tbody>
        <tr>
          <th scope="row">{{$sn}}</th>
          <td>
              <img src="{{asset('images/'.$post->image)}}" class="img-thumbnail" height="200px" width="200px" alt="">
          </td>
          <td>
              <div class="container">
                  <a href="{{route('admin.show_post',$post->id)}}">{{$post->title}}</a>
                  <p>{{$post->body}}</p>
              </div>
          </td>
          <td>
            <p class="badge bg-success">{{$post->status}}</p>
          </td>
          <td>
            <div class="container d-flex">
              <div class="column">
                <a href="{{route('admin.post_trash',$post->id)}}" class="btn btn-warning mx-2">Delete Post</a>
              </div>
              <div class="column"> 
                <form id="delete-frm" class="" action="{{route('admin.user_destroy',$post->user_id)}}" method="POST">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-danger mx-2">Delete User</button>
                </form>
              </div>
            </div>
          </td>
        </tr>
      </tbody>
      <?php $sn++ ?>
      @endforeach
    </table>
    {{$posts->links()}}
</div>

@endsection