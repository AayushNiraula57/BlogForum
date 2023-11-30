<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Models\BlogPost;
use App\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        return view('blog.index', [
                'posts' => $posts,
            ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Auth::user()){
            return redirect()->route('login')->withError('Please Login To Access The Page');
        }else{
            return view('blog.create');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBlogRequest $request)
    {
        // $data = $request->validated();
        $post = $this->postRepository->storePost($request->all());

        return redirect('blog/' . $post->id);   
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = BlogPost::where('id',$id)->first();
        return view('blog.show', [
            'post' => $post,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogRequest $request, string $id)
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = BlogPost::where('id',$id)->first();
        if(Auth::user()->id == $post->user_id){
            $post->delete();
            return redirect('/blog');
        }else{
            return redirect('blog/' . $post->id)->with('message','You do not have permission to delete!!');
        }
    }
}
