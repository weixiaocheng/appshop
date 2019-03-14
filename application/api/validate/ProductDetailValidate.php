<?php
namespace app\api\validate;

use think\Validate;

class ProductDetailValidate extends Validate
{
    protected $rule = [
        'product_id' => 'require'
    ];

    protected $message = [
        'product_id.require' => '商品id不能为空'
    ];
}