<?php
namespace app\api\controller;
use app\api\model\BaseUser;
use app\api\model\UserModel;
use think\Controller;
use think\Request;
use think\db;
/**
 * @title 用户模块
 * @description 主要用于用户登录 注册 忘记密码
 * @author 微笑城
 */
class User extends Controller
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
     * @return \think\response\Json
     */
    public function loginApp()
    {
        $data = [];
        if ($this->request->isPost() == false)
        {
            return showJson($data,false,200,'请使用post进行网络请求');
        }
        $passData = input('post.');

        $validate = new \app\api\validate\User();
        if (!$validate ->check($passData)) {
            return showJson($data,true,400,$validate->getError());
        }

        // 开始验证传入的值
        $userinfo = BaseUser::get(['user_name'  => $passData['name']]);
        if (empty($userinfo)) {
            return showJson([],false,400, '用户不存在');
        }
    }
}