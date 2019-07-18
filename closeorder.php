<?php
/**
 * Created by PhpStorm.
 * User: whisper
 * Date: 2019/7/18
 * Time: 11:21
 */
require_once 'data/extend/RedisServer.php';

ini_set('default_socket_timeout', -1);  //不超时
$redis = RedisServer::getInstance(array('host' => '127.0.0.1','port' => 6379));

// 解决Redis客户端订阅时候超时情况
$redis->setOption();
$redis->psubscribe(array('__keyevent@0__:expired'), 'keyCallback');
// 回调函数,关闭订单
function keyCallback($redis, $pattern, $chan, $msg)
{
    $order_id = $msg;
    $url = 'http://test.buyyan.com/shop/order/closeorder';
    $res = httpUtil($url,array('order_id'=>$order_id),'POST');
    echo $res;
}
function httpUtil($url, $data = '', $method = 'GET')
{
    try {

        $curl = curl_init(); // 启动一个CURL会话
        curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); // 从证书中检查SSL加密算法是否存在
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
        if ($method == 'POST') {
            curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
            if ($data != '') {
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
            }
        }
        curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
        curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
        $tmpInfo = curl_exec($curl); // 执行操作
        curl_close($curl); // 关闭CURL会话
        return $tmpInfo; // 返回数据
    } catch (Exception $e) {
        var_dump($e->getMessage());
    }
}