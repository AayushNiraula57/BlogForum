<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Repositories\Interfaces\PostRepositoryInterface;

class UnverifiedPostController extends Controller
{
    private $postRepository;

    public function __construct(PostRepositoryInterface $postRepository){
        
        $this->postRepository = $postRepository; 

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = $this->postRepository->unverifiedPosts();
        return view('admin.posts.show-unverified',['posts'=> $posts]);
        //dd($posts);
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = $this->postRepository->findPost($id);
        return view('admin.posts.show',['post'=>$post]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->postRepository->updateStatus($id);
        return redirect()->route('admin.show_unverified');
    }



}
