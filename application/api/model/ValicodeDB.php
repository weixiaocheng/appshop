<?php
namespace app\api\model;

use think\Model;

class ValicodeDB extends Model
{
    protected $table = 'vali_code';

    protected $connection = 'db_config';
}