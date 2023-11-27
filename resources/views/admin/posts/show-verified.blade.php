@extends('admin.layouts.layout')
@include('admin.inc.navbar')
@section('content')
<?php 
$sn=1;
$allData = $posts->getData();
$data = $allData->data;
$count = count($data);
// dd($data[0]->id);
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
      @for($i=0;$i<$count;$i++)
      <tbody>
        <tr>
          <th scope="row">{{$sn}}</th>
          <td>
              <img src="{{asset('images/'.$data[$i]->image)}}" class="img-thumbnail" height="200px" width="200px" alt="">
          </td>
          <td>
              <div class="container">
                  <a href="">{{$data[$i]->title}}</a>
                  <p>{{$data[$i]->body}}</p>
              </div>
          </td>
          <td>
            <p>{{$data[$i]->status}}</p>
          </td>
          <td>
            <div class="container d-flex">
              <a href="{{route('admin.verify',$data[$i]->id)}}" class="btn btn-success mx-2">Edit</a>
              <a href="" class="btn btn-danger mx-2">Delete</a>
            </div>
          </td>
        </tr>
      </tbody>
      <?php $sn++ ?>
      @endfor
    </table>
</div>

@endsection