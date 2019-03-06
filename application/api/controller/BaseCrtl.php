<?php
namespace app\api\controller;

use app\api\validate\ValiCode;
use think\Controller;

class BaseCrtl extends Controller
{
    /**
     * @title  发送验证码
     * @description
     * @author 微笑城
     * @url /api/
     * @param name:id type:int require:1 default:1 other: desc:唯一ID
     * @return \think\response\Json
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
            if ($result)
            {
             return showJson([]);
            }else{
                return showJson([], 3001);
            }
        }
    }
}