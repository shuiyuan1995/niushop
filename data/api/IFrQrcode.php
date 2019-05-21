<?php
/**
 * Created by PhpStorm.
 * User: whisper
 * Date: 2019/5/21
 * Time: 10:55
 */
namespace data\api;

interface IFrQrcode
{
    function addQrcodeFrom($data);

    function getQrfrom($page_index = 1, $page_size = 0, $condition = '', $field = '*');

    function deleteQrfrom($id);
}