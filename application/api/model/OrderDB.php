<?php
namespace app\api\model;

use think\Model;

class OrderDB extends Model
{
    protected $table = 'order';

    protected $connection = 'db_config';

    protected $pk = 'order_id';
}