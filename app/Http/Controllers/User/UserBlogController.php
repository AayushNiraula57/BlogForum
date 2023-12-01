<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\PostRepositoryInterface;

class UserBlogController extends Controller
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
        $posts = $this->postRepository->userPosts();
        return view('blog.user-posts', [
            'posts' => $posts,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = $this->postRepository->findPost($id); 
        return view('blog.user-post-edit', [
            'post' => $post,
        ]);
    }

}
