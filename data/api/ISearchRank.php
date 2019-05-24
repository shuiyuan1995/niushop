<?php
/**
 * Created by PhpStorm.
 * User: whisper
 * Date: 2019/5/21
 * Time: 10:55
 */
namespace data\api;

interface ISearchRank
{
    function addKeyword($data);

    function getKeyword($page_index = 1, $page_size = 0, $condition = '', $field = '*');

    function deleteKeyword($id);
}