<?php
namespace app\admin\controller;

use app\admin\validate\UserList;
use app\api\model\BaseUser;
use think\Controller;
use app\api\service\token;
/**
 * @title 后台登录
 * Class User
 * @package app\admin\controller
 */
class User extends Controller
{
    /**
     * @title  后台登录
     * @description
     * @author 微笑城
     * @url /api/User/loginAdmin
     * @method POST
     * Date: 2019-03-23
     * @param name:contact type:int require:1 default:1 other: desc:唯一ID
     * @param name:password type:int require:1 default:1 other: desc:唯一ID
     * Time: 16:01
     * @return array:数组值
     */
    public function loginAdmin()
    {
        if ($this->request->isPost() == false)
        {
            return \showJson([],400);
        }
        $passData = input('post.');
        $validata = new \app\admin\validate\User();
        if ($validata ->check($passData) == false)
        {
            return showJson([],400,true, $validata->getError());
        }

        # 验证用户是否存在
        $userinfo = \app\admin\model\User::get(['user_name'  =>  $passData['name']]);
        if (empty($userinfo)) {
            return showJson([],400,400, '用户不存在');
        }

        if ($userinfo["user_pass"] === $passData["user_pass"])
        {
            $token = token::generateToken();
            $userinfo["token"] = $token;
            \app\admin\model\User::update(["token" =>$token],["user_id" => $userinfo["user_id"]]);
            return showJson($userinfo);
        }else{
            return showJson([],400,400, '账户密码错误');
        }

        return showJson([]);
    }


    public function getUserList()
    {
        if ($this->request->isGet() == false)
        {
            return showJson([], 400);
        }
        $passData = input('get.');
//        dump($passData);
        $passHeader = $this->request->header('token');
        $passData['token'] = $passHeader;
//        dump($passData);
        $validata = new UserList();
        if ($validata ->check($passData) == false)
        {
            return showJson([], 400, true, $validata->getError());
        }

        # 检验用户是否存在
        $userinfo = \app\admin\model\User::get(['user_name'  =>  $passData['name']]);
        if (empty($userinfo)) {
            return showJson([],400,400, '用户不存在');
        }

        # 返回注册用户列表
        $page_size = (int)$passData['page_size'];
        $page_index = (int)$passData['page_index'];

        $userList = BaseUser::limit(($page_index-1)*$page_size , $page_size);
        return showJson($userList, 200, false, "获取用户列表成功");
    }
}