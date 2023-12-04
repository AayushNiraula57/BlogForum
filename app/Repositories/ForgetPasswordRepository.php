<?php
namespace App\Repositories;

use App\Models\User;
use App\Notifications\ResetPasswordNotification;
use App\Repositories\Interfaces\ForgetPasswordInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class ForgetPasswordRepository implements ForgetPasswordInterface{

    public function submitForgetPasswordForm($data){
        $token = Str::random(6);
        DB::table('password_reset_tokens')->insert([
            'email' => $data->email,
            'token' => $token,
            'created_at' => now(),
        ]);

        $user = User::where('email',$data->email)->first();
        $project = [
            'greeting' => 'Hi '.$user->name.',',
            'body' => "Forget Password Email",
            'thanks' => 'Thank you for your cooperation.',
            'actionText' => 'Reset Password',
            'actionURL' => url('reset-password/'.$token),
        ];
  
        Notification::send($user, new ResetPasswordNotification($project));
    }

    public function submitResetPasswordForm($data){
        $updatePassword = DB::table('password_reset_tokens')
        ->where([
            'email' => $data->email,
            'token' => $data->token,
        ])->first();
        if(!$updatePassword){
        return back()->withInput()->with('error', 'Invalid token!');
        }

        $user = User::where('email',$data->email)
        ->update([
            'password' => Hash::make($data->password)
        ]);

        DB::table('password_reset_tokens')->where('email',$data->email)->delete();
    }
}