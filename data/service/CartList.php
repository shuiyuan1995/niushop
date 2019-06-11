<?php
namespace data\service;

use think\Db;
use data\api\ICartList;

class CartList implements ICartList
{
    public function getKeyword($page_index = 1, $page_size = 0, $condition = '', $field = '*')
    {
        $count = Db::query('SELECT COUNT(DISTINCT  `buyer_id`) as count FROM `ns_cart`');
        $count = $count[0]['count'];

        $user = Db::query('SELECT DISTINCT(c.buyer_id),m.member_name FROM `ns_cart` c INNER JOIN `ns_member` m ON c.buyer_id=m.uid limit '.$page_size*($page_index-1).','.$page_size);

        if ($page_index == 1 && $page_size == 0){
            foreach ($user as $k => $v){
                $data[$v['member_name']] = Db::name('ns_cart')
                    ->alias('c')
                    ->join('ns_member m','c.buyer_id = m.uid')
                    ->where($condition)
                    ->where('buyer_id',$v['buyer_id'])
                    ->order('c.cart_id','desc')
                    ->select();
                foreach ($data[$v['member_name']] as $key => $value){
                    if (!empty($value['ip'])){
                        $data[$v['member_name']][$key]['ip'] = long2ip($value['ip']);
                    }
                }
            }
            $page_count = 1;
        }else{
            foreach ($user as $k => $v){
                $data[$v['member_name']] = Db::name('ns_cart')
                                            ->alias('c')
                                            ->join('ns_member m','c.buyer_id = m.uid')
                                            ->where($condition)
                                            ->where('buyer_id',$v['buyer_id'])
                                            ->order('c.cart_id','desc')
                                            ->select();
                foreach ($data[$v['member_name']] as $key => $value){
                    if (!empty($value['ip'])){
                        $data[$v['member_name']][$key]['ip'] = long2ip($value['ip']);
                    }
                }
            }
            $page_count = ceil($count/$page_size);
        }
        if ($data){
            $list['total_count'] = $count;
            $list['page_count'] = $page_count;
            $list['data'] = $data;
            return $list;
        }else{
            $list['total_count'] = 0;
            $list['page_count'] = 0;
            $list['data'] = '';
            return $list;
        }
    }
}