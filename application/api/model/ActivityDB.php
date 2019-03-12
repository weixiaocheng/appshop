<?php
namespace app\api\model;

use think\Model;

class ActivityDB extends Model
{
    protected $pk = 'activity_id';
    protected $table = 'activity';
    protected $connection = 'db_config';
}