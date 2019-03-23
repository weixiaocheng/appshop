<?php
namespace app\api\validate;

use think\Validate;

class OrderCreateValidate extends Validate
{
    protected $rule = [
        'token' => 'require',
        'product_id' => 'require',
        'cart_id' => 'require',
        'address_id' => 'require',
        'quantity' => 'require|number|between:1,9999',
    ];
}