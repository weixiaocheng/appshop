<?php
namespace app\api\controller;
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
        # 直接从数据库里面取数据就可以了 取前五条

    }
}