<?php

namespace App\Http\Responses;
use Illuminate\Http\Response;

class ApiResponse{

    private $data;
    private $message;

    public function __construct($data=null,$message=null){
        $this->data = $data;
        $this->message = $message;
    }
    public function successResponse(){
        return response()->json([
            'status' => true,
            'code' => Response::HTTP_OK,
            'data' => $this->data,
            'message' => $this->message,
        ]);
    }

    public function errorResponse(){
        return response()->json([
            'status' => false,
            'code' => Response::HTTP_BAD_REQUEST,
            'data' => $this->data,
            'message' => $this->message,
        ]);
    }
}

?>