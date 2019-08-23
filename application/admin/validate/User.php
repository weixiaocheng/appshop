<?php
namespace app\admin\validate;

use think\Validate;

class User extends Validate
{
    protected $rule = [
        'name' => 'require',
        'password' => 'require'
    ];
}