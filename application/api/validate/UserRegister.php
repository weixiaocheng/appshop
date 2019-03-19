<?php
namespace app\api\validate;

class UserRegister extends User
{
    protected $rule = [
        'code' => 'require|max:6',
        'mobile' => 'require',
        'password' => 'require',
        'user_name' => 'require'
    ];

    protected $message = [
        'code.require' => '验证码不能为空',
        'code.max' => "验证码长度不能超过6位",
        'mobile' => '手机号码不能为空'
    ];
}