<?php
namespace App\Repositories;

use App\Models\BlogPost;
use App\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class PostRepository implements PostRepositoryInterface{
    public function allPosts(){
        return BlogPost::with('user')->where('status','approved')->orderBy('created_at','desc')->paginate(2);
        // $response = new ApiResponse($posts,'Blog Posts Retrived Successfully!');
        // $response = $response->successResponse();
    }

    public function storePost($data){
        if(file_exists($data['image'])){
            $image = file($data['image']);
            $filename = time() . '.' . $data['image']->extension();
            $data['image']->move(public_path('images'), $filename);
            };

            $post = BlogPost::create([
                'title' => $data['title'],
                'body' => $data['body'],
                'image' => $filename,
                'user_id' => Auth::user()->id,
            ]);

            return $post;
    }

    public function findPost($id){

    }

    public function updatePost($data,$id){

    }

    public function destroyPost($id){
        
    }
}