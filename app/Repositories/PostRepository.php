<?php
namespace App\Repositories;

use App\Models\BlogPost;
use App\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class PostRepository implements PostRepositoryInterface{
    public function allPosts(){
        return BlogPost::with('user')->orderBy('created_at','desc')->paginate(2);
        // $response = new ApiResponse($posts,'Blog Posts Retrived Successfully!');
        // $response = $response->successResponse();
    }

    public function verifiedPosts(){
        return BlogPost::with('user')->where('status','approved')->orderBy('created_at','desc')->paginate(2);
        // $response = new ApiResponse($posts,"All Posts Retrived Successfully");
        // $response = $response->successResponse();
    }

    public function unverifiedPosts(){
        return BlogPost::with('user')->where('status','unapproved')->orderBy('created_at','desc')->paginate(2);
        // $response = new ApiResponse($posts,"All Posts Retrived Successfully");
        // $response = $response->successResponse();
    }

    public function userPosts(){
        return BlogPost::with('user')->where('user_id',Auth::user()->id)->orderBy('created_at','desc')->paginate(2);
        // $response = new ApiResponse($data,'Blog Posts Retrived Successfully!');
        // $response = $response->successResponse();
    }

    public function storePost($data){
        if($data->has('image')){
            $image = $data->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $data->image->move(public_path('images'), $filename);
            };

            $post = BlogPost::create([
                'title' => $data->title,
                'body' => $data->body,
                'image' => $filename,
                'user_id' => Auth::user()->id,
            ]);

            return $post;
    }

    public function findPost($id){
        return BlogPost::where('id',$id)->first();
    }

    public function updatePost($data,$id){
        $post = BlogPost::find($id);
        if($data->has('image')){
            $image= $data->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $data->image->move(public_path('images'), $filename);
            $post->title = $data->title;
            $post->body = $data->body;
            $post->image = $filename;
          }
        else{
            $post->title = $data->title;
            $post->body = $data->body;
          }
          
        $post->save();

        return $post;
    }

    public function updateStatus($id){
        $post = BlogPost::find($id);
        $post->status = 'approved';
        $post->save();
    }

    public function destroyPost($id){
        $post = BlogPost::withTrashed()->find($id);
        $post->forceDelete();
    }
}