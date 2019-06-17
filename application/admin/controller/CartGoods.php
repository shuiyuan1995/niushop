<?php
/**
 * Created by PhpStorm.
 * User: whisper
 * Date: 2019/5/21
 * Time: 14:10
 */

namespace app\admin\controller;

use data\service\CartList;

class CartGoods extends BaseController
{
    public function index()
    {
        if (request()->isAjax()) {
            $cart = new CartList();
            $page_index = request()->post("page_index", 1);
            $page_size = request()->post('page_size', PAGESIZE);
            $start_date = request()->post('start_date') == "" ? 0 : request()->post('start_date');
            $end_date = request()->post('end_date') == "" ? 0 : request()->post('end_date');

            $condition = array();
            if ($start_date != 0 && $end_date != 0) {
                $condition["add_time"] = [
                    [
                        ">",
                        $start_date
                    ],
                    [
                        "<",
                        $end_date
                    ]
                ];
            } elseif ($start_date != 0 && $end_date == 0) {
                $condition["add_time"] = [
                    [
                        ">",
                        $start_date
                    ]
                ];
            } elseif ($start_date == 0 && $end_date != 0) {
                $condition["add_time"] = [
                    [
                        "<",
                        $end_date
                    ]
                ];
            }
            $list = $cart->getKeyword($page_index, $page_size, $condition);

            return $list;
        }else{
            return view($this->style . "CartGoods/index");
        }
    }

    public function excelList(){
        $cart = new CartList();
        $start_date = request()->post('start_date') == "" ? 0 : request()->post('start_date');
        $end_date = request()->post('end_date') == "" ? 0 : request()->post('end_date');

        $condition = array();
        if ($start_date != 0 && $end_date != 0) {
            $condition["search_time"] = [
                [
                    ">",
                    $start_date
                ],
                [
                    "<",
                    $end_date
                ]
            ];
        } elseif ($start_date != 0 && $end_date == 0) {
            $condition["search_time"] = [
                [
                    ">",
                    $start_date
                ]
            ];
        } elseif ($start_date == 0 && $end_date != 0) {
            $condition["search_time"] = [
                [
                    "<",
                    $end_date
                ]
            ];
        }
        $list = $cart->getKeyword(1, 0, $condition);

        return $list;
    }

    public function dataExcel()
    {
        $xlsName  = "扫码访问列表";
        $xlsCell  = array(
            array('keyword','搜索关键词'),
            array('search_times','搜索次数'),
            array('search_time','最后搜索时间')
        );

        $cart = new CartList();
        $start_date = request()->get('start_date') == "" ? 0 : request()->post('start_date');
        $end_date = request()->get('end_date') == "" ? 0 : request()->post('end_date');

        $condition = array();
        if ($start_date != 0 && $end_date != 0) {
            $condition["search_time"] = [
                [
                    ">",
                    $start_date
                ],
                [
                    "<",
                    $end_date
                ]
            ];
        } elseif ($start_date != 0 && $end_date == 0) {
            $condition["search_time"] = [
                [
                    ">",
                    $start_date
                ]
            ];
        } elseif ($start_date == 0 && $end_date != 0) {
            $condition["search_time"] = [
                [
                    "<",
                    $end_date
                ]
            ];
        }
        $list = $cart->getKeyword(1, 0, $condition);
        $list = $list["data"];
        dataExcel($xlsName,$xlsCell,$list);
    }
}