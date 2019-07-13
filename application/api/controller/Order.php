<?php
namespace app\api\controller;

use app\api\model\AddressModel;
use app\api\model\BaseUser;
use app\api\model\CartDB;
use app\api\model\OrderAddressDB;
use app\api\model\OrderDB;
use app\api\model\OrderProuductID;
use app\api\model\ProductDB;
use app\api\validate\OrderCreateValidate;
use think\Controller;

/**
 * @title 订单模块
 * Class Order
 * @package app\api\controller
 */
class Order extends Controller
{

    /**
     * @title  创建订单
     * @description
     * @author 微笑城
     * @url /api/Order/create_Order
     * @method POST
     * @param name:token type:int require:1 default:1 other: desc:唯一ID
     * @param name:cart_id type:int require:1 default:1 other: desc:唯一ID
     * @param name:address_id type:int require:1 default:1 other: desc:唯一ID
     * Date: 2019-03-22
     * Time: 19:11
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @return array:数组值
     */
    public function create_Order()
    {
        if ($this->request->isPost() == false)
        {
            return showJson([],400);
        }

        $passData = input('post.');
        $passHeader = $this->request->header('token');
        $passData['token'] = $passHeader;
        $validate = new OrderCreateValidate();
        if ($validate ->check($passData) == false)
        {
            return showJson([],400, true, $validate->getError());
        }

        # 查看用是否存在
        $user_id = BaseUser::where(['token' => $passData['token']])->find()->getData('user_id');
        if (empty($user_id))
        {
            return showJson([], 4001);
        }

        # 查看购物车是否存在

        # 查看地址
        $address = AddressModel::where(['address_id' => $passData['address_id']])->find();
        if (empty($address))
        {
            return showJson([], 6001);
        }

        # 获取购物车对象
        $cart_obj = CartDB::where(['cart_id' => $passData['cart_id']])->find();
        if (empty($cart_obj))
        {
            return showJson([], 7001);
        }

        # 生成对象
        $order = new OrderDB();
        # 存入地址id
        $order ->user_id = $user_id;
        # 存入订单id
        $order_id =  $this->createOrderNO();
        $order ->order_id = $order_id;
        # 总金额
        $order ->totalPayPirce = $cart_obj['price']*$cart_obj['quantity'];
        # 状态
        $order ->status_id = 1;
        $order ->status = "待付款";
        # 保存数据
        $isSuccess = $this->createOrderSuccess($cart_obj,$address, $order_id, $user_id);

        if ($isSuccess != 200)
        {
            $this->safeAction($order_id,$user_id);
            return showJson([], $isSuccess,true, '创建订单失败');
        }

        $isSaveSuccess = $order ->save();

        if ($isSaveSuccess == false) {
            $this->safeAction($order_id,$user_id);
            return showJson([], 400,true, '创建订单失败');
        }

        $this->delectCartId($cart_obj['cart_id']);

        return showJson([]);
    }

    /**
     * 创建订单编号
     */
    private function createOrderNO()
    {
        // 获取当前时间
        $orderTime = time();
        return "WXC".$orderTime;
    }

    /**
     * 创建订单成功 之后的操作
     * 1. 存入 商品快照 在购物车里面的信息
     * 2. 移除购物车id
     * 3. 存入 地址
     */
    private function createOrderSuccess($cart_obj, $address_obj, $order_id, $user_id) {
        $orderAddress = new OrderAddressDB();
        # 存入唯一的订单编号
        $orderAddress -> order_id = $order_id;
        $orderAddress->name = $address_obj['name'];
        $orderAddress->mobile = $address_obj['mobile'];
        $orderAddress->province = $address_obj['province'];
        $orderAddress->city = $address_obj['city'];
        $orderAddress->area = $address_obj['area'];
        $orderAddress->address = $address_obj['address'];
        $orderAddress->address_id = $address_obj['address_id'];
        $orderAddress->user_id = $user_id;
        $isSuccess = $orderAddress->save();
        if ($isSuccess == false)
        {
            return 7002;
        }

        # 存入商品
        $orderProduct = new OrderProuductID();
        $orderProduct -> order_id = $order_id;
        $orderProduct->product_id = $cart_obj['product_id'];
        $orderProduct->user_id = $user_id;
        $orderProduct->quantity = $cart_obj['quantity'];
        $orderProduct->product_title = $cart_obj['product_name'];
        $orderProduct->product_main_url = $cart_obj['product_img'];
        $orderProduct->price = $cart_obj['price'];
        $isSuccess = $orderProduct->save();
        if ($isSuccess == false)
        {
            return 7003;
        }
        return 200;
    }

    /**
     * 加入购物车成功 移除 商品的id
     * 先查询是否存在 , 然后删除
     */
    private function delectCartId($cart_id) {

        CartDB::where(['cart_id' => $cart_id])->delete();
    }

    /**
     * 安全措施 如果创建订单失败 那么删除 所以 和 这个id 有关的记录
     */
    private function safeAction($order_id, $user_id) {
        OrderAddressDB::where(['cart_id' => $order_id, 'user_id' => $user_id])->delete();
        OrderProuductID::where(['order_id' => $order_id, 'user_id' => $user_id]) ->delete();
    }
}