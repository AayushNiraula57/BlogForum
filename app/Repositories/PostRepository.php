<?php
namespace App\Repositories;

use App\Http\Responses\ApiResponse;
use App\Models\BlogPost;
use App\Models\User;
use App\Notifications\EmailNotification;
use App\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class PostRepository implements PostRepositoryInterface{
    public function allPosts(){
        return BlogPost::with('user')->orderBy('created_at','desc')->paginate(2);
        // $response = new ApiResponse($posts,'Blog Posts Retrived Successfully!');
        // $response = $response->successResponse();
    }

    public function verifiedPosts($path){
        
        $posts = BlogPost::with('user')->where('status','approved')->latest()->get()->toArray();  
        $posts = paginate($posts , 2);
        $posts->withPath($path);
        $response = new ApiResponse($posts,"All Posts Retrived Successfully");
        $response = $response->successResponse();
        return $response;
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
        $post = BlogPost::where('id',$id)->first();
        $user = User::where('id',$post->user_id)->first();
        $project = [
            'greeting' => 'Hi '.$user->name.',',
            'body' => "Your post titled "."'".$post->title."'"." has been accepted.",
            'thanks' => 'Thank you for your contribution to this Blog application',
            'actionText' => 'View Post',
            'actionURL' => url('blog/'.$post->id),
        ];
  
        Notification::send($user, new EmailNotification($project));
    }

    public function destroyPost($id){
        $post = BlogPost::withTrashed()->find($id);
        $post->forceDelete();
    }

    public function searchPost($location){
        $posts = BlogPost::with('user')
                    ->where('status','approved')
                    ->where('title', 'like', '%' . request('search') . '%')
                    ->latest()->get()->toArray();
        $posts = paginate($posts , 2);
        $posts->withPath($location);
        $response = new ApiResponse($posts,"All Posts Retrived Successfully");
        $response = $response->successResponse();
        return $response;
    }
}