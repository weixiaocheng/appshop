<?php
namespace app\api\validate;

use think\Validate;

class ForgetPassword extends Validate
{
    protected  $rule = [
        'password' => "require",
    ];

    protected $message = [
        'password.require' => '密码不能为空',
    ];
}