<?php
namespace app\api\model;

use think\Model;

class OrderProuductID extends Model
{
    protected $table = "order_product";

    protected $connection = 'db_config';
}