<?php
namespace app\admin\validate;

use think\Validate;

class User extends Validate
{
    protected $rule = [
        'contact' => 'require',
        'password' => 'require'
    ];
}