@extends('admin.layouts.layout')
@include('admin.inc.navbar')
@section('title','Dashboard')
@section('content')
<?php 
$sn=1;
?>
<div class="container">
    <div class="column d-flex justify-content-between my-3">
        <a href="{{route('admin.show_unverified')}}" class="btn btn-primary">Verify Posts</a>
        <a href="{{route('admin.show_verified')}}" class="btn btn-primary">Manage Posts</a>
        <a href="{{route('admin.trash')}}" class="btn btn-primary">Trash</a>
    </div>
    <h4>All Posts</h4>
    <table class="table">
        <thead>
          <tr>
            <th scope="col">S.N.</th>
            <th scope="col">Image</th>
            <th scope="col">Blog</th>
            <th scope="col">Status</th>
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
            @if($post->status == 'approved')
            <p class="badge bg-success mt-1">Approved</p>
            @endif
            @if($post->status == 'unapproved')
            <p class="badge bg-warning mt-1">Unapproved</p>
            @endif
          </td>
        </tr>
      </tbody>
      <?php $sn++ ?>
      @endforeach
    </table>
    {{$posts->links()}}
</div>

@endsection