<?php
namespace app\api\model;

use think\Model;

class OrderAddressDB extends Model
{
    protected $table = "order_address";

    protected $connection = 'db_config';

    protected $pk = 'order_id';
}