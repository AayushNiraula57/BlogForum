<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\BlogPost;
use Illuminate\Http\Request;

class AdminBlogController extends Controller
{
    public function dashboard(){
        $posts = BlogPost::with('user')->latest()->take(10)->get()->toArray();
        $response = new ApiResponse($posts,"All Posts Retrived Successfully");
        $response = $response->successResponse();
        return view('admin.dashboard',['posts'=> $response]);
    }

    public function displayUnverifiedPosts(){
        $posts = BlogPost::with('user')->where('status','unapproved')->latest()->take(10)->get()->toArray();
        $response = new ApiResponse($posts,"All Posts Retrived Successfully");
        $response = $response->successResponse();
        return view('admin.posts.show-unverified',['posts'=> $response]);
    }

    public function verifyPosts(String $id){
        $post = BlogPost::find($id);
        $post->status = 'approved';
        $post->save();
        return redirect()->route('admin.show_unverified');
    }

    public function displayVerifiedPosts(){
        $posts = BlogPost::with('user')->where('status','approved')->latest()->take(10)->get()->toArray();
        $response = new ApiResponse($posts,"All Posts Retrived Successfully");
        $response = $response->successResponse();
        return view('admin.posts.show-unverified',['posts'=> $response]);
    }
}
