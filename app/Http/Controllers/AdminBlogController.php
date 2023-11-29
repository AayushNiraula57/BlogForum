<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Http\Request;

class AdminBlogController extends Controller
{
    public function dashboard(){
        $posts = BlogPost::with('user')->orderBy('created_at','desc')->paginate(1);
        // $response = new ApiResponse($posts,"All Posts Retrived Successfully");
        // $response = $response->successResponse();
        return view('admin.dashboard',['posts'=> $posts]);
    }

    public function displayUnverifiedPosts(){
        $posts = BlogPost::with('user')->where('status','unapproved')->orderBy('created_at','desc')->paginate(1);
        // $response = new ApiResponse($posts,"All Posts Retrived Successfully");
        // $response = $response->successResponse();
        return view('admin.posts.show-unverified',['posts'=> $posts]);
    }

    public function verifyPosts(String $id){
        $post = BlogPost::find($id);
        $post->status = 'approved';
        $post->save();
        return redirect()->route('admin.show_unverified');
    }

    public function displayVerifiedPosts(){
        $posts = BlogPost::with('user')->where('status','approved')->orderBy('created_at','desc')->paginate(1);
        $response = new ApiResponse($posts,"All Posts Retrived Successfully");
        $response = $response->successResponse();
        return view('admin.posts.show-verified',['posts'=> $posts]);
    }

    public function destroyUser(User $user){
        $user->delete();
        return redirect()->route('admin.show_verified');
    }

    public function destroyPost($id){
            $post = BlogPost::find($id);
            $post->delete();
            return redirect('/admin/dashboard');
    }

    public function trash(){
        $posts = BlogPost::onlyTrashed()->orderBy('created_at','desc')->paginate(1);
        return view('admin.posts.trash',compact('posts'));
    }

    public function restore($id){
        $posts = BlogPost::withTrashed()->find($id);
        $posts->restore();
        return redirect()->route('admin.trash');
    }
}
