<?php
namespace app\api\validate;

class ValiCode extends BaseValidate
{
    protected $rule = [
        'mobile' => 'require|max:11',
        'type' => 'require',
    ];

    protected $message = [
        'mobile.require' => '手机号码不能为空',
        'mobile.max' => '手机号码为11wei',
        'type.require' => '验证码类型不能为空',
    ];
}