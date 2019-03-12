<?php
namespace app\api\model;

use think\Model;

class Msg_senderDB extends Model
{
    // protected $table = 'base_user';
    protected $table = 'message_sender';
    protected $connection = 'db_config';
    protected $pk = 'user_id';
    protected $field = ['mes_token'];
}