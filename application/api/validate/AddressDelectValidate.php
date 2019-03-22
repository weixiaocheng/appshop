<?php
namespace app\api\validate;

use think\Validate;

class AddressDelectValidate extends Validate
{
    protected $rule = [
        'token' => 'require',
        'address_id' => 'require'
    ];
}