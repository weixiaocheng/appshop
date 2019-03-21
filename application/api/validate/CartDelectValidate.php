<?php
namespace app\api\validate;

use think\Validate;

class CartDelectValidate extends Validate
{
    protected $rule = [
        'cart_id' => 'require',
        'token' => 'require',
    ];
}