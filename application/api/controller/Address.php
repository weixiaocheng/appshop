<?php
namespace app\api\controller;

use app\api\model\AddressModel;
use app\api\model\BaseUser;
use app\api\validate\AddressAddValidate;
use app\api\validate\AddressListValidate;
use app\api\validate\AddressModifValidate;
use think\Controller;

/**
 * @title 地址模块
 * Class Address
 * @package app\api\controller
 */
class Address extends Controller
{
    /**
     * @title  添加地址
     * @description
     * @author 微笑城
     * @url /api/Address/addAddress
     * @method POST
     * @param name:name type:string require:1 default:1 other: desc:收件人
     * @param name:mobile type:number require:1 default:1 other: desc:联系电话
     * @param name:province type:string require:1 default:1 other: desc:省份
     * @param name:city type:string require:1 default:1 other: desc:城市
     * @param name:area type:string require:1 default: other: desc:区/镇
     * @param name:token type:string require:1 default other: desc:..
     * Date: 2019-03-14
     * Time: 17:34
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @return array:数组值
     */
    public function addAddress()
    {
        //支持 相同信息添加
        if ($this->request->isPost() == false)
        {
            return showJson([],400);
        }

        $passData = input('post.');
        $validata = new AddressAddValidate();
        if ($validata ->check($passData) == false)
        {
            return showJson([], 400, true,$validata->getError());
        }

        # 获取用户的id
        $user_id = BaseUser::where(['token' => $passData['token']])->find()->getData('user_id');
        if (empty($user_id))
        {
            return showJson([], 4002);
        }

        $address = new  AddressModel();
        $address->name = $passData['name'];
        $address->mobile = $passData['mobile'];
        $address->province = $passData['province'];
        $address->city = $passData['city'];
        $address->area = $passData['area'];
        $address->address = $passData['address'];
        $address->user_id = $user_id;
        return $address->save() ? showJson([]) : showJson([], 400, true, '保存失败');
    }

    /**
     * @title  获取地址列表
     * @description
     * @author 微笑城
     * @url /api/Address/getAddressList
     * @method POST
     * @param name:id type:int require:1 default:1 other: desc:唯一ID
     * Date: 2019-03-22
     * Time: 16:10
     * @return array:数组值
     */
    public function getAddressList () {
        if ($this->request->isGet() == false)
        {
            return showJson([], 400);
        }

        $passData = input('get.');

        $validata = new AddressListValidate();
        if ($validata->check($passData) == false)
        {
            return showJson([], 400, true,$validata->getError());
        }

        $user_id = BaseUser::where(['token' => $passData['token']])->find()->getData('user_id');
        if (empty($user_id))
        {
            return showJson([],4002);
        }

        # 获取列表
        $result = AddressModel::where(['user_id' => $user_id]) ->select();
        return showJson($result);
    }

    /**
     * @title  修改收货地址
     * @description
     * @author 微笑城
     * @url /api/Address/updateAddress
     * @method POST
     * @param name:id type:int require:1 default:1 other: desc:唯一ID
     * Date: 2019-03-22
     * Time: 16:52
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @return array:数组值
     */
    public function updateAddress () {
        if ($this ->request ->isPost() == false) {
            return showJson([], 400,true, '4646');
        }

        $passData = input('post.');

        $validate = new AddressModifValidate();
        if ($validate ->check($passData) == false)
        {
            return showJson([], 400, true,$validate->getError());
        }

        $user_id = BaseUser::where(['token' => $passData['token']])->find()->getData('user_id');
        if (empty($user_id))
        {
            return showJson([],4002);
        }

        # 查看对应的 地址是否存在
        $address = AddressModel::where(['user_id' => $user_id, 'address_id' => $passData['address_id']]);
        if (empty($address)) {
            return showJson([], 4002);
        }

        # 开始更新
        $isSuccess = AddressModel::update([
            'name' =>$passData['name'] ,
            'mobile' => $passData['mobile'],
            'province' => $passData['province'],
            'city' => $passData['city'],
            'area' => $passData['area'],
            'address_id' => $passData['address_id']
        ] );

        if ($isSuccess)
        {
            return showJson([]);
        }else{
            return showJson([], 400,true, '123456');
        }
    }
}