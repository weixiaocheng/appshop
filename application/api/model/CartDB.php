<?php
namespace app\api\model;

use think\Model;

class CartDB extends Model
{
    protected $table = 'cart';

    protected $connection = 'db_config';

    protected $pk = 'cart_id';
}