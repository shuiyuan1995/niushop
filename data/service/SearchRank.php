<?php
namespace data\service;

use think\Db;
use data\api\ISearchRank;

class SearchRank implements ISearchRank
{
    public function addKeyword($keyword)
    {
        $data['keyword'] = $keyword;
        Db::name('ns_search_keywords')->insert($data);
    }

    public function getKeyword($page_index = 1, $page_size = 0, $condition = '', $field = '*')
    {
        if ($condition){
            $count = Db::name('ns_search_keywords')->where($condition)->count('DISTINCT keyword');
        }else{
            $count = Db::name('ns_search_keywords')->count('DISTINCT keyword');
        }

        $subQuery = Db::name('ns_search_keywords')->where($condition)->order('search_time','DESC')->limit(1000000)->buildSql();
        if ($page_index == 1 && $page_size == 0){
            $sql = "SELECT keyword,count(keyword) as search_times,search_time FROM ({$subQuery}) s  GROUP BY s.keyword ORDER BY search_times desc";
            $data = Db::query($sql);
            $page_count = 1;
        }else{
            $start = ($page_index-1)*$page_size;
            $sql = "SELECT keyword,count(keyword) as search_times,search_time FROM ({$subQuery}) s GROUP BY s.keyword ORDER BY search_times desc limit $start,$page_size";
            $data = Db::query($sql);
            $page_count = ceil($count/$page_size);
        }

        foreach ($data as $k=>$v){
            $data[$k]['goods'] = Db::name('ns_goods')->field('goods_id,goods_name,price,clicks,real_sales')
                                    ->where('goods_name|keywords','like','%' .$v['keyword'] . '%')
                                    ->order('clicks','DESC')->select();
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
        $res = Db::name('ns_search_keywords')->where('keyword','in',$id)->delete();
        return $res;
    }
}