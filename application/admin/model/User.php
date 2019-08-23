<?php
namespace app\admin\model;

use think\Model;

class User extends Model
{
    protected $table = 'admin_base_user';
    protected $connection = 'db_config';
    protected $pk = 'user_id';
}