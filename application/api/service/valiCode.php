<?php
namespace app\api\service;

use app\api\model\ValiCodeDB;

class valiCode
{
    public static function senderCode($mobile)
    {
        $result = ValiCodeDB::get(['mobile' => $mobile]);
        # 获取验证码
        $code = getValiCode(4);
        # 判断手机号码是否存在
        if (!empty($result))
        {
            ValiCodeDB::update(["code" => $code], ['mobile' => $mobile]);
        }

        $code = new ValiCodeDB();
        $code ->mobile = $mobile;
        $code ->code = $code;
        $code ->type = 1;
        $code->save();
    }
}