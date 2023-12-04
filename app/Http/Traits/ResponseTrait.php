<?php
namespace App\Http\Traits;

use Illuminate\Http\Response;

trait ResponseTrait{
    public function successResponse($data,$code,$message){
        return response()->json([
            'status' => true,
            'code' => Response::HTTP_OK,
            'data' => $data,
            'message' => $message,
        ]);
    }

    public function errorResponse($data,$code,$message){
        return response()->json([
            'status' => false,
            'code' => Response::HTTP_BAD_REQUEST,
            'data' => $data,
            'message' => $message,
        ]);
    }
}