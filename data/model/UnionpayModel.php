<?php
namespace data\model;

use think\Db;
use think\Model;

class UnionpayModel extends Model
{
   protected $table = 'c_card';//表名

   
   //新增订单
   function insertData($arr)
   {
   // return Db::table($this->table)->insertGetId($data);
   // return Db::table($this->table)->insertGetId($res);
   return DB::table($this->table)->insertGetId($arr);
   }
}