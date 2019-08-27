<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 2019/8/26
 * Time: 下午6:44
 */

namespace app\admin\validate;

use think\Validate;

class UserList extends Validate
{
    protected  $rule = [
        'token' => 'require',
        'page_size' => 'number|between:1, 20',
        'page_index' => 'require|number| >=:0'
    ];

    protected $message = [
        'token.require' => 'token 不能为空',
        'page_size.number' => '每页长度必须为数字',
        'page_size.between' => '每页最多有20行',
        'page_index.number' => '起始页为1 必须为数字',
        'page_index.require' => '起始页必须传'
    ];
}