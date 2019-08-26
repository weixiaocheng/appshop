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

class userLiser extends Validate
{
    protected  $rule = [
        'token' => 'require',
        'page_size' => 'number|between:1, 20',
        'page_index' => 'require|number'
    ];

    protected $message = [
        'token.require' => 'token 不能为空',
        'page_size.number' => '每页长度必须为数字',
        'page_size.between' => '每页最多有20行',
        'page_index.number' => '起始页为1 必须为数字',
        'page_index.require' => '起始页必须传'
    ];
}