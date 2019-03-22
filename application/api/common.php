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
         strlen($str) < $length;
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
        4005 => '手机号码已注册',
        4006 => '手机号码不存在',
        // 关于验证码
        3001 => '发送验证码失败',
        3002 => '验证码验证失败',
        3003 => '手机号不存在对应的验证码',
        3004 => '验证码错误',
        3005 => '验证码过期',
        // 关于地址
        6001 => '地址不存在'
    ];

    return $errorArr[$code];
}

/**
 * @param $message
 * @param $token
 * @param int $badge
 * @param bool $production
 * @title  消息推送服务
 * @description
 * @author 微笑城
 * @url /api/* @param $message
 * @param $token
 * @param int $badge
 * @param bool $production
 * @method POST
 * @param name:id type:int require:1 default:1 other: desc:唯一ID
 * Date: 2019-03-07
 * Time: 12:02
 * @return array:数组值
 */
function apnsMessageSender($message, $token, $badge = 1 , $production = true)
{
    if (empty($token) || empty($message)) return false;

    $pass = 123456;
    $pem_dir = dirname(__FILE__) ."/push_production.pem";

    $ssl_url = $production ? 'ssl://gateway.push.apple.com:2195' : 'ssl://gateway.sandbox.push.apple.com:2195';
    //声音
    $sound = 'Duck.wav';
    $body['aps'] =[
        'alert' => $message,
        'sound' => $sound,
    ];
    if($badge > 0)
        $body['aps']['badge'] = $badge;
    $payload = json_encode($body);

    $ctx = stream_context_create();
    stream_context_set_option($ctx, 'ssl', 'local_cert', $pem_dir);
    stream_context_set_option($ctx, 'ssl', 'passphrase', $pass);
    $fp = stream_socket_client($ssl_url, $err, $errstr, 60, STREAM_CLIENT_CONNECT, $ctx);

    if (!$fp) {
         dump("Failed to connect $err $errstr\n");
        return FALSE;
    }

    // send message
    $msg = chr(0) . pack("n",32) . pack('H*', str_replace(' ', '', $token)) . pack("n",strlen($payload)) . $payload;
    fwrite($fp, $msg);
    fclose($fp);

    return TRUE;

}
