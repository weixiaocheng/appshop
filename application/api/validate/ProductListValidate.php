<?php
namespace app\api\validate;

use think\Validate;

class ProductListValidate extends Validate
{
    protected $rule = [
        'page_index' => 'require',
    ];
}