<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\PostRepositoryInterface;

class PostController extends Controller
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
        $posts = $this->postRepository->allPosts();
        return view('admin.dashboard',['posts'=> $posts]);
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
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->postRepository->destroyPost($id);
        return redirect()->route('admin.trash');
    }
}
