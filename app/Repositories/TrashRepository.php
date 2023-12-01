<?php
namespace App\Repositories;

use App\Models\BlogPost;
use App\Repositories\Interfaces\TrashRepositoryInterface;

class TrashRepository implements TrashRepositoryInterface{

    public function alltrashedPosts(){
        return BlogPost::onlyTrashed()->orderBy('created_at','desc')->paginate(2);
    }

    public function findTrashedPosts($id){
        return BlogPost::onlyTrashed()->where('id',$id)->first();
    }

    public function restore($id){
        $posts = BlogPost::withTrashed()->find($id);
        $posts->restore();
    }

    public function destroy($id){
        $post = BlogPost::find($id);
        $post->delete();
    }
}