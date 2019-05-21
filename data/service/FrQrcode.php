<?php
namespace data\service;

use think\Db;
use data\api\IFrQrcode;

class FrQrcode implements IFrQrcode
{
    public function addQrcodeFrom($data)
    {
        $ip = $data['ip'];
        $res = Db::name('ns_qrfrom')->where('ip',$ip)->find();
        if ($res){
            Db::name('ns_qrfrom')->where('ip',$ip)->setInc('visits',1);
        }else{
            Db::name('ns_qrfrom')->insert($data);
        }
    }

    public function getQrfrom($page_index = 1, $page_size = 0, $condition = '', $field = '*')
    {
        if ($condition){
            $count = Db::name('ns_qrfrom')->where($condition)->count();
        }else{
            $count = Db::name('ns_qrfrom')->count();
        }

        if ($page_index == 1 && $page_size == 0){
            $data = Db::name('ns_qrfrom')->field($field)->where($condition)->order('from_time','desc')->select();
            $page_count = 1;
        }else{
            $data = Db::name('ns_qrfrom')->field($field)->where($condition)->order('from_time','desc')->page($page_index,$page_size)->select();
            $page_count = ceil($count/$page_size);
        }

        if ($data){
            $list['total_count'] = $count;
            $list['page_count'] = $page_count;
            $list['data'] = $data;
            return $list;
        }else{
            return '';
        }
    }

    public function deleteQrfrom($id)
    {
        $res = Db::name('ns_qrfrom')->where('id','in',$id)->delete();
        return $res;
    }
}