<?php
namespace app\api\controller;

use app\api\model\BaseUser;
use app\api\model\CartDB;
use app\api\model\ProductDB;
use app\api\model\SkuDB;
use app\api\validate\ProductAddCart;
use app\api\validate\ProductDetailValidate;
use app\api\validate\ProductListValidate;
use think\Controller;
use think\Request;

/**
 * Class 商品模块
 * @title 商品模块
 * @package app\api\controller
 */
class Product extends Controller
{
    /**
     * @title  显示商品详情
     * @description
     * @author 微笑城
     * @url /api/Product/getGoodDetail
     * @method get
     * @param name:product_id type:int require:1 default:1 other: desc:唯一ID
     * Date: 2019-03-12
     * Time: 13:49
     * @return array:数组值
     */
    public function getGoodDetail()
    {
        # 判断请求方式
        $data = [];
        if ($this->request->isGet() == false)
        {
            return showJson($data,400,400,'请使用get进行网络请求');
        }
        $passData = input('get.');
        # 验证数据
        $validare = new ProductDetailValidate();
        if (!$validare->check($passData))
        {
            return showJson([], 400, false, $validare->getError());
        }

        # 开始获取数据
        $productModel = new  ProductDB();
        $resutl = $productModel::find($passData['product_id']);
//        $skuModel = new SkuDB();
//        $sku_list = $skuModel::where(['product_id' => $passData['product_id']])->select();
//        dump($sku_list);
//        $resutl['sku_list'] = $sku_list;
        if (empty($resutl))
        {
            return showJson([],200,false,"没有商品信息");
        }
        return showJson($resutl);
    }

    /**
     * @title  获取商品列表
     * @description
     * @author 微笑城
     * @url /api/Product/getProductList
     * @method GET
     * @param name:page_index type:int require:1 default:1 other: desc:页数
     * @param name:page_size type:int require:1 default:5 other desc:每页的个数
     *
     * Date: 2019-03-12
     * Time: 14:54
     * @return array:数组值
     */
    public function getProductList() {

        if ($this->request->isGet() == false)
        {
            return showJson([],400,true,'请使用get 进行网络请求');
        }
        $passData = input('get.');
        #验证数据
        $validate = new  ProductListValidate();
        if (!$validate -> check($passData))
        {
            return showJson([], 400,true,$validate->getError());
        }
        if (empty($passData['page_size']))
        {
            $passData['page_size'] = 5;
        }
        #开始获取数据
        $productList = new  ProductDB();
        $result = $productList::limit($passData['page_size'])->page($passData['page_index'])->order('product_id','desc')->select();
        return showJson($result);
    }

    /**
     * @title  加入购物车
     * @description
     * @author 微笑城
     * @url /api/
     * @method POST
     * @param name:product_id type:int require:1 default:1 other: desc:唯一ID
     * @param name:user_id type:int require:1 default:1 other: desc:唯一ID
     * @param name:quantity type:int require:1 default:1 other: desc:唯一ID
     * Date: 2019-03-12
     * Time: 16:12
     * @return array:数组值
     */
    public function addShoppingCart()
    {
        if ($this->request->isPost() == false)
        {
            return showJson([],400,true, '请使用post 网络请求');
        }

        $passData = input('post.');
        $passHeader = $this->request->header('token');
        $passData['token'] = $passHeader;
        $validate = new ProductAddCart();
        if (!$validate ->check($passData))
        {
            return showJson([],400, true, $validate->getError());
        }

        #根据token 查询要用户的user_id 然后用户id 查询 购物车列表 暂时不考虑token 过期的问题

        $user = BaseUser::where(['token' => $passData['token']])->find();

        if (empty($user))
        {
            return showJson(array(),401,true,'用户不存在');
        }

        # 查询商品是否存在 或者 已下架
        $product = ProductDB::find($passData['product_id']);
        if (empty($product))
        {
            return showJson([], 3002,true, "商品不存在");
        }


        $cart = new CartDB();
        # 查询购物车里面是否已经包含了该商品
        $result = CartDB::where(['product_id' => $passData['product_id'],'user_id' => $user['user_id']])->limit(1)->find();

        # 加入购物车 并传入用户id
        $cart->product_id = $passData['product_id'];
        $cart->user_id = $user['user_id'];
        $cart->quantity = $passData['quantity'];
        $cart->product_name = $product['product_title'];
        $cart->product_img = $product['product_main_url'];
        $cart->price = $product['price'];

        if (!empty($result))
        {
            $quantity = $passData['quantity'] + $result['quantity'];
            $isSuccess = $cart::update(['product_id' => $passData['product_id'] , 'quantity' => $quantity],['cart_id' => $result['cart_id']]);
        }else{
            $isSuccess = $cart->save();
        }

        if ($isSuccess)
        {
            return showJson([]);
        }else{
            return showJson([],400);
        }
    }

}