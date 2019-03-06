<?php
namespace app\api\controller;
use app\api\model\BaseUser;
use app\api\model\UserModel;
use app\api\service\token;

use app\api\service\valiCode;
use app\api\validate\ForgetPassword;
use app\api\validate\LoginPassword;
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
class User
{
    /**
     * @title  用户登录
     * @description
     * @author 微笑城
     * @url /api/User/loginApp
     * @method POST
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
     * @title  用户注册
     * @description
     * @author 微笑城
     * @method POST
     * @url /api/User/userRegisterApp
     * @param name:id type:int require:1 default:1 other: desc:唯一ID
     * @return name:名称
     *
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

        #检查手机号是否存在
        $useinfo = BaseUser::get(['mobile' => $passData['mobile']]);
        if (!empty($useinfo))
        {
            return showJson($data, 4005);
        }

        #检查验证码是否正确
        $code = valiCode::valicode($passData['mobile'],$passData['code'],1);
        if ($code !== 200)
        {
            return showJson([], $code);
        }

        $userRegister = new \app\api\model\UserReister();
        $userRegister -> user_name = $passData['name'];
        $userRegister -> password = $passData['password'];
        $userRegister -> code = $passData['code'];
        $result = $userRegister->save();
        if ($result) {
            return showJson([]);
        }else {
            return showJson([],4004);
        }
    }

    /**
     * @title  重置密码
     * @description
     * @author 微笑城
     * @url /api/
     * @method POST
     * @param name:id type:int require:1 default:1 other: desc:唯一ID
     * Date: 2019-03-06
     * Time: 17:32
     * @return array:数组值
     */
    public function forgetPassword()
    {
        $data = [];
        if ($this->request->isPost() == false)
        {
            return showJson($data, 400);
        }
        $passData = input('post.');
        $validata = new ForgetPassword();
        if (!$validata ->check($passData))
        {
            return showJson($data,400,400,$validata->getError());
        }

        # 检查用户是否存在
        $result = BaseUser::get(['mobile' => $passData['mobile']]);
        if (empty($result))
        {
            return showJson($data,4006);
        }

        # 验证验证码
        $code = valiCode::valicode($passData['mobile'],$passData['code'],3);
        if ($code != 200)
        {
            return showJson($data, $code);
        }

        #更新用户密码
        $user = \app\api\model\UserReister::update(['password' => $passData["password"]],['mobile' => $passData['mobile']]);
        return showJson($code);
    }

    /**
     * @title  账户密码登录
     * @description
     * @author 微笑城
     * @url /api/user/loginWithcode
     * @method POST
     * @param name:mobile type:int require:1 default:1 other: desc:手机号
     * @param name:code type:int require:1 default:1 other: desc:验证码
     * Date: 2019-03-06
     * Time: 17:55
     * @return array:数组值
     */
    public function loginWithcode()
    {
        $data = [];
        if ($this->request->isPost() == false)
        {
            return showJson($data,400);
        }

        $passData = input('post.');

        $validata = new LoginPassword();

        if (!$validata->check($passData))
        {
            return showJson($data,400,400,$validata->getError());
        }

        # 检查用户是否存在
        $result = BaseUser::get(['mobile' => $passData['mobile']]);
        if (empty($result))
        {
            return showJson($data,4006);
        }

        # 验证验证码
        $code = valiCode::valicode($passData['mobile'],$passData['code'],2);
        if ($code != 200)
        {
            return showJson($data, $code);
        }

        # 返回用户信息
        $result['token'] = token::saveTokenWithUserId($result['mobile']);
        return showJson($result);

    }



}