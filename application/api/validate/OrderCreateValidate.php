<?php
namespace app\api\validate;

use think\Validate;

class OrderCreateValidate extends Validate
{
    protected $rule = [
        'token' => 'require',
        'cart_id' => 'require',
        'address_id' => 'require',
    ];
}