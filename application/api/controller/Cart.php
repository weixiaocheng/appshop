<?php
namespace app\api\controller;

use app\api\model\BaseUser;
use app\api\model\CartDB;
use app\api\validate\CartDelectValidate;
use app\api\validate\CartListValidate;
use app\api\validate\CartModifValidate;
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

        # 查询用户对于的 购物车列表里面是否包含有 商品列表
        $result = CartDB::where(['user_id' => $user['user_id']])->select();
        if (empty($result))
        {
            return showJson([],200);
        }

        return showJson($result);
    }


    /**
     * @title  修改购物车数量
     * @description
     * @author 微笑城
     * @url /api/cart/modifQuantity
     * @method POST
     * @param name:id type:int require:1 default:1 other: desc:唯一ID
     * Date: 2019-03-14
     * Time: 14:52
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @return array:数组值
     */
    public function modifQuantity() {
        if ($this->request->isPost() == false)
        {
            return showJson([],400, true,'请使用post 进行网络请求');
        }
        $passData = input('post.');
        $passHeader = $this->request->header('token');
        $passData['token'] = $passHeader;
        $validata = new CartModifValidate();
        if ($validata->check($passData) == false)
        {
            return showJson([],400, true, $validata->getError());
        }

        # 根据用户id 查询 商品的id
        $user_id = BaseUser::where(['token' => $passData['token']])->find()->getData('user_id');

        if (empty($user_id))
        {
            return showJson([],400, true,'用户不存在');
        }

        # 根据user_id 和购物车id  查询商品
        $result = CartDB::where(['user_id' => $user_id , 'cart_id' => $passData['cart_id']])->find();
        if (empty($result))
        {
            return showJson([], 400 , true ,'购物车id不存在');
        }

        # 开始更新购物车数量
        $cart = new CartDB();
        $isSuccess = $cart::update(['product_id' => $passData['cart_id'] , 'quantity' => $passData['quantity']],['cart_id' => $result['cart_id']]);
        if ($isSuccess)
        {
            return showJson([]);
        }
        else
        {
            return showJson([],400, true,'更新数量失败');
        }
    }

    /**
     * @title  购物车删除
     * @description
     * @author 微笑城
     * @url /api/cart/delectWithCartId
     * @method POST
     * @param name:id type:int require:1 default:1 other: desc:唯一ID
     * Date: 2019-03-14
     * Time: 15:27
     * @return array:数组值
     */
    public function delectWithCartId()
    {
        if ($this->request->isPost() == false)
        {
            return showJson([],400, false, "请使用post 网络请求");
        }

        $passData = input('post.');
        $passHeader = $this->request->header('token');
        $passData['token'] = $passHeader;

        $validata = new  CartDelectValidate();
        if ($validata ->check($passData) == false)
        {
            return showJson([], 400 , true, $validata->getError());
        }

        # 获取用的的id
        $user_id = BaseUser::where(['token' => $passData['token']])->find()->getData('user_id');
        if (empty($user_id))
        {
            return showJson([],400, true, '用户不存在');
        }

        $result = CartDB::where(['user_id' => $user_id, 'cart_id' => $passData['cart_id']])->find();
        if (empty($result))
        {
            return showJson([],400, true, '购物车商品不存在');
        }
        $isSuccess = CartDB::where(['user_id' => $user_id, 'cart_id' => $passData['cart_id']])->delete();
        if ($isSuccess)
        {
            return showJson([]);
        }
        else
            {
            return showJson([], 400, true, '操作失败');
        }
    }
}