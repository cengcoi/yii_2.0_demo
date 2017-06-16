<?php
/**
 * @author: xin
 * Date: 2016/8/5
 * Time: 15:53
 */

namespace app\components;


class Security
{
    CONST PREFIX = '$2y$11$';
    /**
     * 生成安全哈希密码和盐值
     * @param $password
     * @return array
     */
    public static function generateHash($password) {
        $salt =  self::PREFIX . substr(md5(uniqid(rand(), true)), 0, 22);
        return ['password'=>crypt($password, $salt),'salt'=>$salt];
    }

    /**
     * 获取哈希密码
     * @param string $password  初始密码
     * @param string $salt      盐值
     * @return string
     */
    public static function getHash($password,$salt){
        return crypt($password, $salt);
    }
}