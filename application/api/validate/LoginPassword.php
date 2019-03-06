<?php
namespace app\api\validate;

class LoginPassword extends BaseValidate
{
    protected $rule = [
        'mobile' => 'require|max:11',
        'code' => 'require|max:6'
    ];

    protected $message = [
        'mobile.require' => "手机号码不能为空",
        'mobile.max' => '手机号码为11位',
        'code.require' => '请输入验证码',
        'code.max' => '验证码为6位'
    ];
}