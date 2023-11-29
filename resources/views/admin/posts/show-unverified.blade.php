@extends('admin.layouts.layout')
@include('admin.inc.navbar')
@section('content')
<?php 
$sn=1;
?>
<div class="container">
    <h4>All Posts</h4>
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
                  <a href="">{{$post->title}}</a>
                  <p>{{$post->body}}</p>
              </div>
          </td>
          <td>
            <p>{{$post->status}}</p>
          </td>
          <td>
            <div class="container d-flex">
              <div class="column">
                <a href="{{route('admin.post_destroy',$post->id)}}" class="btn btn-success mx-2">Verify</a>
              </div>
              <div class="column"> 
                <form id="delete-frm" class="" action="{{route('blog.destroy',$post->id)}}" method="POST">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-danger mx-2">Delete</button>
                </form>
              </div>
              {{-- <a href="" class="btn btn-danger mx-2">Delete</a> --}}
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