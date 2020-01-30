<?php
namespace app\api\controller;

use app\api\model\Msg_senderDB;
use app\api\validate\BaseValidate;
use app\api\validate\ValiCode;
use think\Controller;

/**
 * Class BaseCrtl
 * @title 基础模块
 * @package app\api\controller
 */
class Basecrtl extends Controller
{

    public function upload() {
        if ($_FILES['file']["error"])
        {
            return showJson([], 500);
        }
//        dump($_SERVER);

        if (empty($_FILES['file']) == true)
        {
            return showJson([], 500, true , '没有获取到文件');
        }

        if($_FILES["file"]["type"]=="image/jpeg"||$_FILES["file"]["type"]=="image/jpg" && $_FILES["file"]["type"]=="image/png"&&$_FILES["file"]["size"]<1024000) {
            $filename = "static/file/".date("YmdHis").$_FILES["file"]["name"];
            $dirPath = "static/file";
            if (!file_exists($dirPath))
            {
                mkdir($dirPath, 0777, true);
            }
            
            $success = move_uploaded_file($_FILES["file"]["tmp_name"],$filename);
            $data = [];
            $data["imageUrl"] = $filename;
            if ($success){
                return showJson($data,200);
            }else{
                return showJson([],500);
            }

        }
    }

    /**
     * @title  发送验证码
     * @description
     * @author 微笑城
     * @url /api/Basecrtl/senderValicode
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

    /**
     * @title  获取所有的苹果设备的token
     * @description
     * @author 微笑城
     * @url /api/BaseCrtl/senderMessage
     * @method POST
     * @param name:id type:int require:1 default:1 other: desc:唯一ID
     * Date: 2019-03-07
     * Time: 10:42
     * @return array:数组值
     */
    public function senderMessage()
    {
        #遍历 数据库里面所有的 token 发送消息 
        $msgDB = new Msg_senderDB();
        $tokens = $msgDB::column('mes_token');
        foreach ($tokens as $code)
        {
            $apnback = apnsMessageSender('这是测试兮兮',$code,1,false);
            dump($apnback);
        }

        return showJson($tokens);
    }
}