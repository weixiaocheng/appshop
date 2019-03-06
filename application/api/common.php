<?php

/**
 * @param $data
 * @param bool $isError
 * @param string $msg
 * @param int $code
 * @return \think\response\Json
 */
function showJson($data,$code = 200, $isError = false,  $msg = '操作成功')
{
    if ($code != 200)
    {
        $data = [];
        $isError = true;
        if ($msg == '操作成功')
        {
            $msg = errorCodeArray($code);
        }

    };

    $result = [
        'isError' => $isError,
        'code' => $code,
        'msg' => $msg ,
        'data' => $data,
    ];
    return json($result);
}

/**
 * @param $length
 * @title  返回随机数
 * @description
 * @author 微笑城
 * @url /api/
 * @param name:id type:int require:1 default:1 other: desc:唯一ID
 * @return string|null
 * Date: 2019-03-05
 * Time: 17:51
 */
function getRandChar($length)
{
    $str = null;
    $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
    $max = strlen($strPol) - 1;

    for ($i = 0;
         $i < $length;
         $i++) {
        $str .= $strPol[rand(0, $max)];
    }

    return $str;
}

/**
 * @param $length
 * @title  获取随机验证码
 * @description
 * @author 微笑城
 * @url /api/
 * @param name:id type:int require:1 default:1 other: desc:唯一ID
 * @return string|null
 * Date: 2019-03-06
 * Time: 10:39
 */
function getValiCode($length)
{
    $str = null;
    $strPol = "0123456789";
    $max = strlen($strPol) - 1;

    for ($i = 0;
         $i < $length;
         $i++) {
        $str .= $strPol[rand(0, $max)];
    }

    return $str;
}

/**
 * @param $code
 * @title  errorCodeArray
 * @description
 * @author 微笑城
 * @url /api/
 * @param name:id type:int require:1 default:1 other: desc:唯一ID
 * @return mixed
 * Date: 2019-03-05
 * Time: 18:22
 */
function errorCodeArray($code) {
    $errorArr = [
        # 关于网络请求
        400 => "网络请求失败",
        401 => "网络请求授权失败",
        402 => "网络请求错误",
        403 => "地址不存在",
        // 关于用户
        4001 => '密码错误',
        4002 => '用户不存在',
        4003 => '用户名称已存在',
        4004 => '注册失败',
        // 关于验证码
        3001 => '发送验证码失败',
        3002 => '验证码验证失败',
        3003 => '手机号不存在对应的验证码',
        3004 => '验证码错误'
    ];

    if (in_array($code,$errorArr)){
        return $errorArr[$code];
    }
    return  "请联系客服".$code;
}
