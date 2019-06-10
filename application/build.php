<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [
    // 生成应用公共文件
    '__file__' => ['common.php'],

    // 定义demo模块的自动生成 （按照实际定义的文件名生成）
    'api'     => [
        '__file__'   => ['common.php'],
        '__dir__'    => ['behavior', 'controller', 'model', 'validate', 'service'],
        'controller' => ['User', 'Address', 'Home','BaseCrtl', 'Product', 'Cart','Order'],
        'model'      => [
            'BaseUser',
            'AddressModel' ,
            'ValicodeDB',
            'Home_BannerDB',
            'Msg_senderDB',
            'ActivityDB',
            'ProductDB',
            'CartDB',
            'ShoppingCart',
            'OrderDB'
            ],
        'validate'   => [
            'User',
            'Address',
            'BaseValidate',
            'UserRegister',
            'Valicode',
            'ForgetPassword',
            'LoginPassword',
            'ProductDetailValidate',
            'ProductListValidate',
            'ProductAddCart',
            'CartListValidate',
            'CartModifValidate', // 购物车修改数量
            'CartDelectValidate', // 购物车删除
            'OrderListValidate', // 订单列表
            'OrderCreateValidate', // 创建订单
            'orderCancelValidate', // 取消订单
            'orderPayValidate', //订单支付
            'AddressListValidate', // 关于地址列表的
            'AddressAddValidate', // 添加地址
            'AddressDelectValidate', // 删除地址
            'AddressModifValidate', // 修改地址
            ],
        'service'    => ['token', 'valiCode'],
        'behavior' => ['CORS']
//        'view'       => ['index/index'],
    ],
    'admin' => [
        '__file__' => ['common.php'],
        '__dir__'    => ['behavior', 'controller', 'model', 'validate', 'service'],
        'controller' => ['User'],
        'model' => ['User'],
        'validate' => ['User'],
        'service' => ['token'],
        'behavior' => ['CORS']
    ]

    // 其他更多的模块定义
];
