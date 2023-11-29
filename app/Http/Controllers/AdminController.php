<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRegisterationRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Responses\ApiResponse;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function index(){
        return view('admin.login');
    }

    public function login(LoginRequest $request){
        
        $credentials = Admin::where('email',$request->email)->first();
        if(is_null($credentials)){
            $response = new ApiResponse($credentials,"Not valid Email Id!");
            return $response->errorResponse();
        }else{
            $credentials = $credentials->toArray();
            $hash = Hash::check($request->password,$credentials['password']);
        }

        if($hash == false){
            $response = new ApiResponse(null,"Not a valid password!");
            return $response->errorResponse();
        }else{
            $request->session()->put('admin',true);
            $request->session()->put('name',$credentials['name']);
            $request->session()->put('id',$credentials['id']);
            return redirect()->route('admin.dashboard');
        }
    }



    public function registration(){
        return view('admin.registration');
    }

    public function registerAdmin(AdminRegisterationRequest $request){

        $data = $request->all();
        $check = $this->store($data);
        return redirect("admin/login")->withSuccess('You have signed-in');
    }

    public function store(array $data){
        return Admin::create([
            'name'=> $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function dashboard(){
        return view('admin.dashboard');
    }

    public function signOut(){
        Session::flush();
        return redirect()->route('admin.login');
    }
}
