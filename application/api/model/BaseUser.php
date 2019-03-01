<?php
namespace app\api\model;

use think\Model;

class BaseUser extends Model
{
    protected $table = 'base_user';

    protected $connection = 'db_config';
}