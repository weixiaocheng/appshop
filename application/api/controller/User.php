<?php
namespace app\api\controller;
use app\api\model\BaseUser;
use app\api\model\UserModel;
use app\api\service\token;

use app\api\validate\UserRegister;
use app\api\validate\UserReister;
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
            return showJson($data,400,400,'请使用post进行网络请求');
        }
        $passData = input('post.');

        $validate = new \app\api\validate\User();
        if (!$validate ->check($passData)) {
            return showJson($data,400,400,$validate->getError());
        }

        // 开始验证传入的值
        $userinfo = BaseUser::get(['user_name'  =>  $passData['name']]);
        if (empty($userinfo)) {
            return showJson([],400,400, '用户不存在');
        }

        if ($userinfo['password'] == $passData['password'])
        {
            $userinfo['token'] = token::saveTokenWithUserId($userinfo['user_id']);
            return showJson($userinfo);
        }else {
            return showJson([],400,401, '用户密码错误');
        }

    }

    /**
     * @title  userRegisterApp
     * @description
     * @author 微笑城
     * @url /api/
     * @param name:id type:int require:1 default:1 other: desc:唯一ID
     * @return \think\response\Json
     * Date: 2019-03-05
     * Time: 18:46
     */
    public function userRegisterApp () {
        $data = [];
        if ($this->request->isPost() == false)
        {
            return showJson($data,400,400,'请使用post进行网络请求');
        }
        $passData = input('post.');
        $validata = new UserRegister();
        if (!$validata ->check($passData))
        {
            return showJson($data,400,400,$validata->getError());
        }

        // 检查用户名是否重复
        $useinfo = BaseUser::get(['user_name' => $passData['name']]);
        if (!empty($useinfo))
        {
            return showJson($data, 4003);
        }

        $userRegister = new \app\api\model\UserReister();
        $userRegister -> name = $passData['name'];
        $userRegister -> password = $passData['password'];
        $userRegister -> code = $passData['code'];
        $result = $userRegister->save();
        if ($result) {
            return showJson([]);
        }else {
            return showJson([],4004);
        }
    }
}