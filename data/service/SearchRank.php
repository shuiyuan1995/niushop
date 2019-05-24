<?php
namespace data\service;

use think\Db;
use data\api\ISearchRank;

class SearchRank implements ISearchRank
{
    public function addKeyword($keyword)
    {
        $data['keyword'] = $keyword;
        $res = Db::name('ns_search_keywords')->where('keyword',$keyword)->find();
        if ($res){
            Db::name('ns_search_keywords')->where('keyword',$keyword)->setInc('search_times',1);
        }else{
            Db::name('ns_search_keywords')->insert($data);
        }
    }

    public function getKeyword($page_index = 1, $page_size = 0, $condition = '', $field = '*')
    {
        if ($condition){
            $count = Db::name('ns_search_keywords')->where($condition)->count();
        }else{
            $count = Db::name('ns_search_keywords')->count();
        }

        if ($page_index == 1 && $page_size == 0){
            $data = Db::name('ns_search_keywords')->field($field)->where($condition)->order('search_times','desc')->select();
            $page_count = 1;
        }else{
            $data = Db::name('ns_search_keywords')->field($field)->where($condition)->order('search_times','desc')->page($page_index,$page_size)->select();
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

    public function deleteKeyword($id)
    {
        $res = Db::name('ns_search_keywords')->where('id','in',$id)->delete();
        return $res;
    }
}