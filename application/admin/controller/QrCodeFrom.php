<?php
/**
 * Created by PhpStorm.
 * User: whisper
 * Date: 2019/5/21
 * Time: 14:10
 */

namespace app\admin\controller;

use data\service\FrQrcode;

class QrCodeFrom extends BaseController
{
    public function index()
    {
        if (request()->isAjax()) {
            $frQrCode = new FrQrcode();
            $page_index = request()->post("page_index", 1);
            $page_size = request()->post('page_size', PAGESIZE);

            $start_date = request()->post('start_date') == "" ? 0 : request()->post('start_date');
            $end_date = request()->post('end_date') == "" ? 0 : request()->post('end_date');

            $condition = array();
            if ($start_date != 0 && $end_date != 0) {
                $condition["from_time"] = [
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
                $condition["from_time"] = [
                    [
                        ">",
                        $start_date
                    ]
                ];
            } elseif ($start_date == 0 && $end_date != 0) {
                $condition["from_time"] = [
                    [
                        "<",
                        $end_date
                    ]
                ];
            }
            $list = $frQrCode->getQrfrom($page_index, $page_size, $condition);

            return $list;
        }else{
            return view($this->style . "QrCodeFrom/index");
        }
    }

    public function delete()
    {
        $id = request()->post('id');
        $frQrCode = new FrQrcode();
        $result = $frQrCode->deleteQrfrom($id);
        if ($result){
            return returnAjax(1,'删除成功');
        }
        return returnAjax(-1,'删除失败');
    }

    public function excelList(){
        $frQrCode = new FrQrcode();
        $start_date = request()->post('start_date') == "" ? 0 : request()->post('start_date');
        $end_date = request()->post('end_date') == "" ? 0 : request()->post('end_date');

        $condition = array();
        if ($start_date != 0 && $end_date != 0) {
            $condition["from_time"] = [
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
            $condition["from_time"] = [
                [
                    ">",
                    $start_date
                ]
            ];
        } elseif ($start_date == 0 && $end_date != 0) {
            $condition["from_time"] = [
                [
                    "<",
                    $end_date
                ]
            ];
        }
        $list = $frQrCode->getQrfrom(1, 0, $condition);

        return $list;
    }

    public function dataExcel()
    {
        $xlsName  = "扫码访问列表";
        $xlsCell  = array(
            array('ip','IP地址'),
            array('country','国家'),
            array('region','省份'),
            array('city','城市'),
            array('from_time','最后访问时间'),
            array('visits','访问次数')
        );

        $frQrCode = new FrQrcode();
        $start_date = request()->get('start_date') == "" ? 0 : request()->post('start_date');
        $end_date = request()->get('end_date') == "" ? 0 : request()->post('end_date');

        $condition = array();
        if ($start_date != 0 && $end_date != 0) {
            $condition["from_time"] = [
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
            $condition["from_time"] = [
                [
                    ">",
                    $start_date
                ]
            ];
        } elseif ($start_date == 0 && $end_date != 0) {
            $condition["from_time"] = [
                [
                    "<",
                    $end_date
                ]
            ];
        }
        $list = $frQrCode->getQrfrom(1, 0, $condition);
        $list = $list["data"];
        dataExcel($xlsName,$xlsCell,$list);
    }
}