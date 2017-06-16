<?php
/**
 * @author: xin
 * Date: 2016/7/12
 * Time: 14:44
 */

namespace app\components;


class Token
{
    /**
     * 加密字符串
     * @param array $info
     * @return string
     */
    public static function encode(array $info)
    {
        $string = $info['member_id']."\t".$info['username'];
        return self::authcode($string, "ENCODE");
    }

    /**
     * 解密字符串
     * @param $string
     * @return array|bool
     */
    public static function decode($string)
    {
        $string = self::authcode($string, "DECODE");
        if(!$string)
            return false;
        if(strpos($string,"\t") === false)
            return false;
        list($member_id, $username) = explode("\t", $string);
        if($member_id && $username ){
            return array('member_id'=>$member_id, 'username'=>$username);
        }
        return false;
    }

    public static function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
        $ckey_length = 4;
        $key = md5($key != '' ? $key : \Yii::$app->params['TOKEN_AUTH_CODE']);
        $keya = md5(substr($key, 0, 16));
        $keyb = md5(substr($key, 16, 16));
        $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';

        $cryptkey = $keya.md5($keya.$keyc);
        $key_length = strlen($cryptkey);

        $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
        $string_length = strlen($string);

        $result = '';
        $box = range(0, 255);

        $rndkey = array();
        for($i = 0; $i <= 255; $i++) {
            $rndkey[$i] = ord($cryptkey[$i % $key_length]);
        }

        for($j = $i = 0; $i < 256; $i++) {
            $j = ($j + $box[$i] + $rndkey[$i]) % 256;
            $tmp = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }

        for($a = $j = $i = 0; $i < $string_length; $i++) {
            $a = ($a + 1) % 256;
            $j = ($j + $box[$a]) % 256;
            $tmp = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
            $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
        }

        if($operation == 'DECODE') {
            if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
                return substr($result, 26);
            } else {
                return '';
            }
        } else {
            return $keyc.str_replace('=', '', base64_encode($result));
        }
    }
}