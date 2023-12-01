<?php
namespace App\Repositories\Interfaces;


Interface PostRepositoryInterface{
    public function allPosts();

    public function userPosts();

    public function verifiedPosts();

    public function unverifiedPosts();

    public function storePost($data);

    public function findPost($id);

    public function updatePost($data,$id);

    public function updateStatus($id);

    public function destroyPost($id);
}