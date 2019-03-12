<?php
namespace app\api\controller;
use app\api\model\ActivityDB;
use app\api\model\Home_BannerDB;
use think\Controller;

/**
 * Class Home
 * @title 首页模块
 * @package app\api\controller
 */
class Home extends Controller
{
    /**
     * @title  获取首页轮播
     * @description
     * @author 微笑城
     * @url /api/Home/homeBanner
     * @method GET
     *
     * Date: 2019-03-06
     * Time: 18:20
     * @return array:数组值
     */
    public function homeBanner()
    {
        # get 方式 没有任何需要验证的 只有可能是没有数据
        # 直接从数据库里面取数据就可以了 取前五条
        $result = Home_BannerDB::select();
        return showJson($result);
    }

    /**
     * @title  获取首页 活动栏
     * @description
     * @author 微笑城
     * @url /api/
     * @method POST
     * @param name:id type:int require:1 default:1 other: desc:唯一ID
     * Date: 2019-03-08
     * Time: 09:37
     * @return array:数组值
     */
    public function homeActivity()
    {
        $result = ActivityDB::limit(0,1)->select();
        return showJson($result);
    }
}