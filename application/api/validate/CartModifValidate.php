<?php
namespace app\api\validate;

use think\Validate;

class CartModifValidate extends Validate
{
    protected $rule = [
        'cart_id' => 'require',
        'quantity' => 'require|between:1,9999'
    ];

    protected  $message = [
        'cart_id.require' => '购物车id 不能为空',
        'quantity.number' => '数量必须为数字',
    ];
}