<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Http\Responses\ApiResponse;
use App\Models\BlogPost;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BlogPostController extends Controller
{
    public function index(){
            $posts = $this->addUserField();
            // $response = new ApiResponse($posts,'Blog Posts Retrived Successfully!');
            // $response = $response->successResponse();
            return view('blog.index', [
                    'posts' => $posts,
                ]);
    }
    
    public function addUserField(){
        $posts = BlogPost::with('user')->where('status','approved')->orderBy('created_at','desc')->paginate(1);
        return $posts;
    }

    public function create()
    {
        
        if (!Auth::user()){
            return redirect()->route('login')->withError('Please Login To Access The Page');
        }else{
            return view('blog.create');
        }
        
    }

   
    public function store(StoreBlogRequest $request): RedirectResponse
    {
        if($request->hasFile('image')){
            $image= $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $request->image->move(public_path('images'), $filename);
            };

            $data = $request->all();
            $newPost = $this->createBlog($data,$filename);


        return redirect('blog/' . $newPost->id);        
    }

    public function createBlog($data,$filename){
        $post = BlogPost::create([
            'title' => $data['title'],
            'body' => $data['body'],
            'image' => $filename,
            'user_id' => Auth::user()->id,
        ]);
        return $post;
    }

    public function show(BlogPost $blogPost)
    {
        return view('blog.show', [
            'post' => $blogPost,
        ]);
    }

    public function showUserPost(String $id)
    {    
        $posts = BlogPost::with('user')->where('user_id',$id)->orderBy('created_at','desc')->paginate(1);
        // $response = new ApiResponse($data,'Blog Posts Retrived Successfully!');
        // $response = $response->successResponse();
        return view('blog.user-posts', [
            'posts' => $posts,
        ]);
    }

    public function managePost(BlogPost $blogPost)
    {
        return view('blog.user-post-edit', [
            'post' => $blogPost,
        ]);
    }

    public function edit(String $id)
    {
        $post = DB::table('blog_posts')->where('id',$id)->first();
        if(Auth::user()->id == $post->user_id){
            return view('blog.edit', [
                'post' => $post,
                ]);
        }else{
            return redirect('blog/' . $post->id)->with('message','You do not have permission to edit!!');
        }
    }

    
    public function update(UpdateBlogRequest $request, String $id): RedirectResponse
    {   
        if($request->hasFile('image')){
            $image= $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $request->image->move(public_path('images'), $filename);
          };

        $post = BlogPost::find($id);
        $post->title = $request->title;
        $post->body = $request->body;
        $post->image = $filename;

        $post->save();
              


        return redirect('blog/' . $post->id);
    }

    
    public function destroy(BlogPost $blogPost)
    {   
        
        if(Auth::user()->id == $blogPost->user_id){
            $blogPost->delete();
            return redirect('/blog');
        }else{
            return redirect('blog/' . $blogPost->id)->with('message','You do not have permission to delete!!');
        }

    }
}
