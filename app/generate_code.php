<?php

use App\Models\UserCode;
use App\Notifications\VerificationCodeNotification;
use Illuminate\Support\Facades\Notification;

function generateCode($user)
    {
        $code = rand(10000, 99999);
        UserCode::updateOrCreate(
            [ 'user_id' => auth()->user()->id ],
            [ 'code' => $code ]
        );
    
        try {
  
            $details = [
                'title' => 'Your verification code is :',
                'code' => $code
            ];

            Notification::send($user, new VerificationCodeNotification($details));
             
    
        } catch (Exception $e) {
            info("Error: ". $e->getMessage());
        }
    }