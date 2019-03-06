<?php
namespace app\api\validate;

use app\api\model\UserReister;

class ForgetPassword extends UserReister
{
    protected  $rule = [
        'password' => "require",
    ];

    protected $message = [
        'password.require' => '密码不能为空',
    ];
}