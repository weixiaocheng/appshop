<?php
namespace app\admin\controller;

use think\Controller;
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
        return showJson([]);
    }
}