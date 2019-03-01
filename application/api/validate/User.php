<?php
namespace app\api\validate;

use think\Validate;

class User extends Validate
{
    protected $rule = [
        'name' => 'require|max:25',
        'password' => 'require',
    ];

    protected $message = [
      'name.require' => '用户名不能为空',
      'password.require' => '密码不能为空',
    ];
}