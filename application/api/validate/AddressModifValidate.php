<?php
namespace app\api\validate;

use think\Validate;

class AddressModifValidate extends Validate
{
    protected $rule = [
        'name' => 'require|max:30',
        'mobile' => 'require|number|max:11',
        'province' => 'require|max:30',
        'city' => 'require|max:30',
        'area' => 'require|max:30',
        'token' => 'require',
        'address_id' => 'require'
    ];
}