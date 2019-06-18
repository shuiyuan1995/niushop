<?php
namespace data\service;

use think\Db;
use data\api\ICartList;

class CartList implements ICartList
{
    public function getKeyword($page_index = 1, $page_size = 0, $condition = '', $field = '*')
    {
        $count = Db::name('ns_cart')->where($condition)->count();

        if ($page_index == 1 && $page_size == 0){
                $data = Db::name('ns_cart')
                    ->alias('c')
                    ->join('ns_member m','c.buyer_id = m.uid','left')
                    ->where($condition)
                    ->order('c.add_time','desc')
                    ->select();
                foreach ($data as $key => $value){
                    $ip = $value['ip'];
                    $data[$key]['ip'] = $ip;
                    if (!empty($value['ip'])){
                        $location = judge_ip($ip);
                        $data[$key]['country'] = $location['country'].' '.$location['region'];
                    }else{
                        $data[$key]['country'] = 'XX XX';
                    }
                }
            $page_count = 1;
        }else{
                $data = Db::name('ns_cart')
                                            ->alias('c')
                                            ->join('ns_member m','c.buyer_id = m.uid','left')
                                            ->where($condition)
                                            ->order('c.add_time','desc')
                                            ->page($page_index,$page_size)
                                            ->select();
                foreach ($data as $key => $value){
                    $ip = $value['ip'];
                    $data[$key]['ip'] = $ip;
                    if (!empty($value['ip'])){
                        $location = judge_ip($ip);
                        $data[$key]['country'] = $location['country'].' '.$location['region'];
                    }else{
                        $data[$key]['country'] = 'XX XX';
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