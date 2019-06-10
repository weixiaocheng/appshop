<?php
namespace app\api\controller;

use app\api\model\AddressModel;
use app\api\model\BaseUser;
use app\api\model\OrderDB;
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
     * @param name:product_id type:int require:1 default:1 other: desc:唯一ID
     * @param name:cart_id type:int require:1 default:1 other: desc:唯一ID
     * @param name:address_id type:int require:1 default:1 other: desc:唯一ID
     * @param name:quantity type:int require:1 default:1 other: desc:唯一ID
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

        $passdata = input('post.');
        $passHeader = $this->request->header('token');
        $passData['token'] = $passHeader;
        $validate = new OrderCreateValidate();
        if ($validate ->check($passdata) == false)
        {
            return showJson([],400, true, $validate->getError());
        }

        # 查看用是否存在
        $user_id = BaseUser::where(['token' => $passdata['token']])->find()->getData('user_id');
        if (empty($user_id))
        {
            return showJson([], 4001);
        }

        # 查看购物车是否存在

        # 查看地址
        $address = AddressModel::where(['address_id' => $passdata['address_id']])->find();
        if (empty($address))
        {
            return showJson([], 6001);
        }

        # 生成对象
        $order = new OrderDB();
        # 存入标题
        $order ->title = $produc['product_title'];
        # 存入商品id
        $order ->product_id = $passdata['product_id'];
        # 存入数量
        $order ->quantity = $passdata['quantity'];
        # 存入价格
        $order ->price = $produc['price'];
        # 存入地址
        $order ->name = $address['name'];
        $order ->mobile = $address['mobile'];
        $order ->address = $address['province'] + $address['city'] + $address['area'] + $address['address'];
        # 存入地址id
        $order ->user_id = $user_id;
        # 总金额
        $order ->total_price = $produc['price']*$produc['quantity'];
        # 保存数据
        $isSuccess = $order ->save();
        if ($isSuccess)
        {
            return showJson([]);
        }else{
            return showJson([], 400,true, '创建订单失败');
        }

    }

}