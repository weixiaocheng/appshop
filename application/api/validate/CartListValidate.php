<?php
namespace app\api\validate;

use think\Validate;

class CartListValidate extends Validate
{
    protected $rule = [
        'page_index' => 'require|number'
    ];
}