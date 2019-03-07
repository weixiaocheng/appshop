<?php
namespace app\api\controller;

use app\api\validate\BaseValidate;
use app\api\validate\ValiCode;
use think\Controller;

/**
 * Class BaseCrtl
 * @title 基础模块
 * @package app\api\controller
 */
class BaseCrtl extends Controller
{
    /**
     * @title  发送验证码
     * @description
     * @author 微笑城
     * @url /api/BaseCrtl/senderValicode
     * @method POST
     * @param name:mobile type:int require:1 default:1 other: desc: 手机号码
     * @param name:type type:string require:1 default:1 other:1,2,3 desc:1:用户注册2:用户登录3:找回密码
     *
     * @return name:名称
     * Date: 2019-03-06
     * Time: 11:42
     */
    public function senderValicode()
    {
        $data = [];
        if ($this->request->isPost() == false)
        {
            return showJson($data,400,400,'请使用post进行网络请求');
        }
        $passData = input('post.');
        $validata = new ValiCode();
        if (!$validata ->check($passData))
        {
            return showJson($data,400,400,$validata->getError());
        }else
        {

            $result = \app\api\service\valiCode::senderCode($passData['mobile'],$passData['type']);
            if ($result == 200)
            {
             return showJson([]);
            }else{
                return showJson([], 3001);
            }
        }
    }

    /**
     * @title  测试
     * @description
     * @author 微笑城
     * @url /api/BaseCrtl/test
     * @method POST
     * @param name:id type:int require:1 default:1 other: desc:唯一ID
     * Date: 2019-03-07
     * Time: 09:42
     * @return array:数组值
     */
    public function test()
    {
        $data = input('post.');
        $data['version'] = $this->request->header('version');
        $validate = new  BaseValidate();
        if ($validate->check($data))
        {
            return showJson([]);
        }else{
            return showJson([], 400,false,$validate->getError());
        }
    }
}