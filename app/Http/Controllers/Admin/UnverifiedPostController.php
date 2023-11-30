<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;

class UnverifiedPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = BlogPost::with('user')->where('status','unapproved')->orderBy('created_at','desc')->paginate(2);
        // $response = new ApiResponse($posts,"All Posts Retrived Successfully");
        // $response = $response->successResponse();
        return view('admin.posts.show-unverified',['posts'=> $posts]);
        //dd($posts);
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = BlogPost::where('id',$id)->first();
        return view('admin.posts.show',['post'=>$post]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = BlogPost::find($id);
        $post->status = 'approved';
        $post->save();
        return redirect()->route('admin.show_unverified');
    }



}
