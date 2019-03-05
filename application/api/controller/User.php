<?php
namespace app\api\controller;
use app\api\model\BaseUser;
use app\api\model\UserModel;
use app\api\service\token;
use think\Controller;
use think\Request;
use think\db;
/**
 * @title 用户模块
 * @description 主要用于用户登录 注册 忘记密码
 * @author 微笑城
 */
class User extends BaseCrtl
{
    /**
     * @title  loginApp
     * @description
     * @author 微笑城
     * @url /api/User
     *
     * @param name:name type:string require:1 default:1 other: desc:用户名
     * @param name:password type:string require:1 default:1 other: desc:用户密码
     * Date: 2019-03-01
     * Time: 16:11
     * @return name:名称
     */
    public function loginApp()
    {

        $data = [];
        if ($this->request->isPost() == false)
        {
            return showJson($data,true,400,'请使用post进行网络请求');
        }
        $passData = input('post.');

        $validate = new \app\api\validate\User();
        if (!$validate ->check($passData)) {
            return showJson($data,true,400,$validate->getError());
        }

        // 开始验证传入的值
        $userinfo = BaseUser::get(['user_name'  =>  $passData['name']]);
        if (empty($userinfo)) {
            return showJson([],true,400, '用户不存在');
        }

        if ($userinfo['password'] == $passData['password'])
        {
            $userinfo['token'] = token::saveTokenWithUserId($userinfo['user_id']);
            return showJson($userinfo);
        }else {
            return showJson([],true,401, '用户密码错误');
        }

    }

    public function userRegisterApp () {
        $data = [];
        if ($this->request->isPost() == false)
        {
            return showJson($data,true,400,'请使用post进行网络请求');
        }
        $passData = input('post.');

    }
}