<?php
namespace app\admin\validate;

use think\Validate;

class User extends Validate
{
    protected $rule = [
        'name' => 'require',
        'user_pass' => 'require'
    ];
}

