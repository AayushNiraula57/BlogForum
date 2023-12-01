<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\TrashRepositoryInterface;
use Illuminate\Http\Request;

class TrashController extends Controller
{
    private $trashRepository;

    public function __construct(TrashRepositoryInterface $trashRepository){
        $this->trashRepository = $trashRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = $this->trashRepository->alltrashedPosts();
        return view('admin.posts.trash',compact('posts'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = $this->trashRepository->findTrashedPosts($id);
        return view('admin.posts.show',['post'=>$post]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,string $id)
    {
        // $posts = BlogPost::withTrashed()->find($id);
        // $posts->restore();
        $this->trashRepository->restore($id);
        return redirect()->route('admin.trash');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->trashRepository->destroy($id);
        return redirect()->route('admin.trash');
    }
}
