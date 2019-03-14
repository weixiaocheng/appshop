<?php
namespace app\api\controller;

use think\Controller;

class Cart extends Controller
{
    public function getCartList()
    {
        if ($this->request->isGet() == false)
        {
            return showJson([], 400);
        }


    }
}