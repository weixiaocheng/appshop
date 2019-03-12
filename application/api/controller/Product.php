<?php
namespace app\api\controller;

use app\api\model\ProductDB;
use app\api\validate\productDetailValidate;
use think\Controller;
use think\Request;

class Product extends Controller
{
    /**
     * @title  显示商品详情
     * @description
     * @author 微笑城
     * @url /api/Product/getGoodDetail/
     * @method POST
     * @param name:id type:int require:1 default:1 other: desc:唯一ID
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
        $resutl = $productModel::find(['product_id' => $passData['product_id']]);
        if (empty($resutl))
        {
            return showJson([],200,false,"没有商品信息");
        }
        return showJson($resutl);

    }
}