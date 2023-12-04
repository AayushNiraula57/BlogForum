<?php
namespace App\Repositories\Interfaces;

Interface ForgetPasswordInterface{

    public function submitForgetPasswordForm($data);

    public function submitResetPasswordForm($data);

}