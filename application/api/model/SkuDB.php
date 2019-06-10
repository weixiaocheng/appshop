<?php
namespace app\api\model;
use think\Model;

class SkuDB extends Model
{
    /** 数据库的名称 */
    protected $table = 'sku';
    /** 数据配置 */
    protected $connection = 'db_config';
    /** id */
    protected $pk = 'sku_id';
}