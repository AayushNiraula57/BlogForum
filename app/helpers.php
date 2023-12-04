<?php

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

if(!function_exists('paginate')){
    function paginate($items,$perPage = 2, $page = null){
        $page = $page ?:(Paginator::resolveCurrentPage() ?: 1);
        $total = count($items);
        $currentPage = $page;
        $offset = ($currentPage * $perPage) - $perPage;
        $itemsToShow = array_slice($items,$offset,$perPage);
        return new LengthAwarePaginator($itemsToShow,$total,$perPage);
    }
}