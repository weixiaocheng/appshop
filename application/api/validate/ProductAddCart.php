<?php
namespace app\api\validate;

use think\Validate;

class ProductAddCart extends Validate
{
    protected $rule = [
        'token' => 'require',
        'product_id' => 'require',
        'quantity' => 'require|number|between:1,9999',
        'token' => 'require'
    ];
}