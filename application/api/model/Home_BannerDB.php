<?php
namespace app\api\model;

use think\Model;

class Home_BannerDB extends Model
{
    protected $table = 'home_banner';

    protected $connection = 'db_config';

    protected $pk = 'banner_id';
}