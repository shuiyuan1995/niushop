<?php
namespace app\common;
/**
 * Created by PhpStorm.
 * User: whisper
 * Date: 2019/4/24
 * Time: 10:29
 */

class Des
{

    public static function encrypt($data, $key)
    {
        /*打开加密算法和模式*/
        $module = mcrypt_module_open('des', '', MCRYPT_MODE_CBC, '');

        /*创建初始向量*/
        $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($module), MCRYPT_RAND);

        /*检测秘钥长度*/
        $key_length = mcrypt_enc_get_key_size($module);

        /*创建秘钥*/
        $key = substr(md5($key), 0, $key_length);

        /*初始化加密*/
        mcrypt_generic_init($module, $key, $iv);

        /*加密数据*/
        $encrypted = $iv.mcrypt_generic($module, $data);

        /*结束加密，执行清理工作*/
        mcrypt_generic_deinit($module);

        /*关闭加密算法和模式*/
        mcrypt_module_close($module);

        return base64_encode($encrypted);
    }

    public static function decrypt($data, $key)
    {
        $data = base64_decode($data);

        /*打开加密算法和模式*/
        $module = mcrypt_module_open('des', '', MCRYPT_MODE_CBC, '');

        /*秘钥*/
        $key = substr(md5($key), 0, mcrypt_enc_get_key_size($module));

        /*向量长度*/
        $ivSize = mcrypt_enc_get_iv_size($module);

        /*获取机密数据向量*/
        $iv = substr($data, 0, $ivSize);

        /*解密初始化*/
        mcrypt_generic_init($module, $key, $iv);

        /*解密数据*/
        $decrypted = mdecrypt_generic($module, substr($data, $ivSize, strlen($data)));

        /*结束解密，执行清理工作*/
        mcrypt_generic_deinit($module);

        /*关闭加密算法和模式*/
        mcrypt_module_close($module);

        $decrypted = rtrim($decrypted, "\0");

        return $decrypted;
    }

}