<?php
namespace App\Repositories\Interfaces;

Interface TrashRepositoryInterface{

    public function alltrashedPosts();

    public function findTrashedPosts($id);

    public function restore($id);

    public function destroy($id);

}