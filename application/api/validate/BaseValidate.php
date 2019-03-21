<?php
namespace app\api\validate;

use think\Validate;

class BaseValidate extends Validate
{
    protected $rule = [
        'version' => 'require',
        'deviceType' => 'require',
        'timestamp' => 'require',
    ];

    protected $message = [
        'version' => '版本号为空',
        'deviceType' => '设备类型为空',
        'timestamp' => '时间不能为空'
    ];
}