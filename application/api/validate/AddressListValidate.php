<?php
namespace app\api\validate;

use think\Validate;

class AddressListValidate extends Validate
{
    protected $rule = [
        'token' => 'require'
    ];
}