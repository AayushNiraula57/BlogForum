<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRegisterationRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Responses\ApiResponse;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.registration');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminRegisterationRequest $request)
    {
        $data = $request->all();
        Admin::create([
            'name'=> $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        return redirect("admin/login")->withSuccess('You have signed-in');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function signout()
    {
        Session::flush();
        return redirect()->route('admin.login');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.show_verified');
    }


}
