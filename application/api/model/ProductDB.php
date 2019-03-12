<?php
namespace app\api\model;

use think\Model;

class ProductDB extends Model
{
    protected $table = 'product';

    protected $connection = 'db_config';

    protected $pk = 'product_id';
}