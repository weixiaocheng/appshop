<?php
namespace app\admin\service;

class token
{
    /**
     * @title  generateToken
     * @description
     * @author 微笑城
     * @url /api/
     * @param name:id type:int require:1 default:1 other: desc:唯一ID
     * @return string
     * Date: 2019-03-05
     * Time: 17:23
     */
    public static function generateToken ()
    {
        $randChar = getRandChar(32);
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
        $tokenSalt = config('y99h.token_salt');
        return md5($randChar.$timestamp.$tokenSalt);
    }

    /**
     * @param $userId
     * @title  saveTokenWithUserId
     * @description
     * @author 微笑城
     * @url /api/
     * @param name:id type:int require:1 default:1 other: desc:唯一ID
     * @return string
     * Date: 2019-03-05
     * Time: 17:39
     */
    public static function saveTokenWithUserId($userId) {
        $token = self::generateToken();
        BaseUser::update(['token' => $token],['user_id' => $userId]);
        return $token;
    }
}