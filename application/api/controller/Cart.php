<?php
namespace app\api\controller;

use app\api\model\BaseUser;
use app\api\model\CartDB;
use app\api\validate\CartListValidate;
use think\Controller;

/**
 * Class Cart
 * @title 购物车模块
 * @package app\api\controller
 *
 */
class Cart extends Controller
{
    /**
     * @title  获取购物车列表
     * @description
     * @author 微笑城
     * @url /api/Cart/getCartList
     * @method get
     * @param name:id type:int require:1 default:1 other: desc:唯一ID
     * Date: 2019-03-14
     * Time: 14:17
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @return array:数组值
     */
    public function getCartList()
    {
        if ($this->request->isGet() == false)
        {
            return showJson([], 400);
        }

        $passData = input('get.');

        $validate = new CartListValidate();
        if ($validate ->check($passData) == false)
        {
            return showJson([], 400,true, $validate->getError());
        }

        # 获取用户的id
        $user = BaseUser::where(['token' => $passData['token']])->find();
        if (empty($user)){
            return showJson([], 400, true, '用户不存在');
        }
        if (empty($passData['page_size']))
        {
            $passData['page_size'] = 5;
        }
        # 查询用户对于的 购物车列表里面是否包含有 商品列表
        $result = CartDB::where(['product_id' => $passData['product_id'],'user_id' => $user['user_id']])->limit($passData['page_size'])->select();
        if (empty($result))
        {
            return showJson([],200);
        }

        return showJson($result);
    }
}