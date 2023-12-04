<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgetPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\User;
use App\Notifications\ResetPasswordNotification;
use App\Repositories\Interfaces\ForgetPasswordInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;


class ForgotPasswordController extends Controller
{
    private $forgetPasswordRepository;

    public function __construct(ForgetPasswordInterface $forgetPasswordRepository)
    {
        $this->forgetPasswordRepository = $forgetPasswordRepository;
    }

    public function index(){
        return view('auth.forget-password');
    }
    public function store(ForgetPasswordRequest $request){

        $this->forgetPasswordRepository->submitForgetPasswordForm($request);

        return back()->with('message', 'We have e-mailed your password reset link!');
    }
    public function show($token){
        return view('auth.forgetPasswordLink', ['token' => $token]);
    }
    public function update(ResetPasswordRequest $request){

        $this->forgetPasswordRepository->submitResetPasswordForm($request);

        return redirect('/login')->with('message', 'Your password has been changed!');
    }
}
