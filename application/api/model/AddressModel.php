<?php
namespace app\api\model;

use think\Model;

class AddressModel extends Model
{
    protected $pk = 'address_id';
    protected $table = 'address';
    protected $connection = 'db_config';
}