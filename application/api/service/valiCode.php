<?php
namespace app\api\service;

use app\api\model\ValicodeDB;

class valiCode
{
    /**
     * @param $mobile
     * @title  讲数据存入到数据库
     * @description
     * @author 微笑城
     * @url /api/
     * @param name:id type:int require:1 default:1 other: desc:唯一ID
     * valitype 类型 1.注册 2.登录 3.找回密码 4.修改交易密码
     * Date: 2019-03-06
     * Time: 10:47
     * @return boolean
     */
    public static function senderCode($mobile, $type)
    {
        $result = ValiCodeDB::get(['mobile' => $mobile]);
        # 获取验证码
        $code = getValiCode(4);
        # 判断手机号码是否存在
        if (empty($result) == false)
        {
            ValiCodeDB::update(["code" => $code], ['mobile' => $mobile]);
            return true;
        }

        $codem = new ValicodeDB();
        $codem ->mobile = $mobile;
        $codem ->code = $code;
        $codem ->valitype = $type;
        return $codem->save();
    }

    /**
     * @param $mobile
     * @param $code
     * @param $valiType
     * @title  验证验证码
     * @description
     * @author 微笑城
     * @url /api/
     * @param name:id type:int require:1 default:1 other: desc:唯一ID
     * @return int
     * Date: 2019-03-06
     * Time: 11:42
     */
    public static function valicode($mobile, $code, $valiType)
    {
        $result = ValicodeDB::get(['mobile' => $mobile, 'valitype' => $valiType]);
        if (empty($result) == true)
        {
            return 3003;
        }

        if ($code != $result['code'])
        {
            return 3004;
        }

        ValicodeDB::update(['code' => null],['mobile' => $mobile]);
        return 200;
    }

}