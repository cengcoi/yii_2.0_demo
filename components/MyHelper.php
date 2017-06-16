<?php
/**
 * @author: xin
 * Date: 2016/6/15
 * Time: 16:53
 */

namespace app\components;

use Yii;

class MyHelper
{
    /**
     * 去除key为空的值
     * @param array $data   原始数组
     * @return mixed
     */
    public static function delEmptyKey($data){
        if(array_key_exists('',$data)){
            unset($data['']);
        }
        return $data;
    }

    /**
     * 获取真实IP
     * @return string
     */
    public static function get_real_ip() {
        $proxy_headers = array(
            'CLIENT_IP',
            'FORWARDED',
            'FORWARDED_FOR',
            'FORWARDED_FOR_IP',
            'HTTP_CLIENT_IP',
            'HTTP_FORWARDED',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED_FOR_IP',
            'HTTP_PC_REMOTE_ADDR',
            'HTTP_PROXY_CONNECTION',
            'HTTP_VIA',
            'HTTP_X_FORWARDED',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_FORWARDED_FOR_IP',
            'HTTP_X_IMFORWARDS',
            'HTTP_XROXY_CONNECTION',
            'VIA',
            'X_FORWARDED',
            'X_FORWARDED_FOR'
        );

        foreach($proxy_headers as $proxy_header)
        {
            if(isset($_SERVER[$proxy_header]) && preg_match("/^([1-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])(\.([0-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])){3}$/", $_SERVER[$proxy_header])) /* HEADER ist gesetzt und dies ist eine gültige IP */
            {
                return $_SERVER[$proxy_header];
            }
            else if(isset($_SERVER[$proxy_header]) && stristr(',', $_SERVER[$proxy_header]) !== FALSE) /* Behandle mehrere IPs in einer Anfrage(z.B.: X-Forwarded-For: client1, proxy1, proxy2) */
            {
                $proxy_header_temp = trim(array_shift(explode(',', $_SERVER[$proxy_header]))); /* Teile in einzelne IPs, gib die letzte zurück und entferne Leerzeichen */

                if(($pos_temp = stripos($proxy_header_temp, ':')) !== FALSE) $proxy_header_temp = substr($proxy_header_temp, 0, $pos_temp); /* Entferne den Port */

                if(preg_match("/^([1-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])(\.([0-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])){3}$/", $proxy_header_temp)) return $proxy_header_temp;
            }
        }

        return $_SERVER['REMOTE_ADDR'];
    }

    /**
     * 截取字符串
     * @param string $str 要截取的字符串
     * @param int $len 长度
     * @param bool $strip_tags 是否清除标签
     * @return string
     */
    public static function str_cut($str, $len=30, $strip_tags=TRUE){
        if($strip_tags)//如果要清除标签。
            $str = strip_tags($str);
        $more = mb_strlen($str,'utf8')<=$len ? '' :'...';
        return mb_substr($str,0,$len,'utf8').$more;
    }

    /**
     * 使用POST方式获取数据
     * @param string $url 提交地址
     * @param array $data 提交的post数据
     * @return mixed
     */
    public static function curlPost($url,$data){
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_POST,true);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
        $return = curl_exec($ch);
        curl_close($ch);
        return $return;
    }

    /**
     * CURL使用GET方式获取数据
     * @param string $url 提交地址
     * @return mixed
     */
    public static function curlGet($url){
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $return = curl_exec($ch);
        curl_close($ch);
        return $return;
    }

    /**
     * 手机号码检测
     * @param string $mobile    手机号码
     * @return bool
     */
    public static function mobileValidate($mobile){
        return preg_match('/^(13[0-9]|14[57]|15[012356789]|17[0678]|18[0-9])[0-9]{8}$/',$mobile) == 0 ? false : true;
    }

    /**
     * 检测字符串是否只是中文、字母、空格
     * @param string $str
     * @return bool
     */
    public static function strValidate($str){
        return preg_match('/^[a-zA-Z\x{4e00}-\x{9fa5}\s]+$/u',$str) == 0 ? false : true;
    }

    /**
     * 检测字符串是否只是中文、字母、数字
     * @param string $str
     * @return bool
     */
    public static function strNumValidate($str){
        return preg_match('/^[a-zA-Z0-9\x{4e00}-\x{9fa5}]+$/u',$str) == 0 ? false : true;
    }

    public static function emailValidate($email){
        return preg_match('/^(\w)+(\.-\w+)*@(\w)+((\.\w{2,3}){1,3})$/i',$email) == 0 ? false : true;
    }

    /**
     * 随机字符串（32位以内）
     * @param int $len
     * @return string
     */
    public static function randomStr($len=6){
        return substr(md5(uniqid()),mt_rand(0,32-$len),$len);
    }

    /**
     * 随机数字串
     * @param int $len  长度
     * @return string
     */
    public static function randomNum($len=5){
        $str = '1234567890';
        $return = '';
        while(strlen($return) < $len){
            $return .= substr($str,mt_rand(0,strlen($str)-1),1);
        }
        return $return;
    }

    /**
     * 订单号生成
     * @return string
     */
    public static function orderSn(){
        return substr(date('Ymd'),1).self::randomNum(2).date('Hi').self::randomNum(3);
    }

    /**
     * 身份证验证
     * @param string $id            身份证号码
     * @param int $checkGender      检测号码的性别（1为男，2为女，0不检测）
     * @return bool
     */
    public static function idValidate($id,$checkGender=0){
        $num = strtolower($id);
        if(preg_match('/(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|x)$)/',$num) == 0)
            return false;
        if(is_numeric($num)){//全部数字
            if(strlen($num) == 15 ){
                // 省市县（6位）
                $areaNum = substr($num,0,6);
                // 出生年月（6位）
                $dateNum = substr($num,6,6);
                // 性别（3位）
                $sexNum = substr($num,12,3);
            }else{
                // 如果是18位身份证号
                // 省市县（6位）
                $areaNum = substr($num,0,6);
                // 出生年月（8位）
                $dateNum = substr($num,6,8);
                // 性别（3位）
                $sexNum = substr($num,14,3);
                // 校验码（1位）
                $endNum = substr($num,17,1);
            }
        }else{
            // 不是数值
            if(strlen($num) == 15){
                return false;
            }else{
                // 验证前17位为数值，且18位为字符x
                $check17 = substr($num,0,17);
                if(!is_numeric($check17)){
                    return false;
                }
                // 省市县（6位）
                $areaNum = substr($num,0,6);
                // 出生年月（8位）
                $dateNum = substr($num,6,8);
                // 性别（3位）
                $sexNum = substr($num,14,3);
                // 校验码（1位）
                $endNum = substr($num,17,1);
                if($endNum != 'x'){//前面已经转化成为小写，不用检查大写X
                    return false;
                }
            }
        }

        if(!self::checkArea($areaNum)){
            return false;
        }

        if(!self::checkDate($dateNum)){
            return false;
        }

        // 性别1为男，2为女
        if($checkGender == 1){
            if(isset($sexNum)){
                if(!self::checkSex($sexNum)){
                    return false;
                }
            }
        }else if($checkGender == 2){
            if(isset($sexNum)){
                if(self::checkSex($sexNum)){
                    return false;
                }
            }
        }

        if(isset($endNum)){
            if(!self::checkEnd($num)){
                return false;
            }
        }

        return true;
    }

    // 验证城市
    private static function checkArea($area){
        $num1 = substr($area,0,2);
        $num2 = substr($area,2,2);
        $num3 = substr($area,4,2);
        // 根据GB/T2260—999，省市代码11到65
        if(10 < $num1 && $num1 < 66){
            return true;
        }else{
            return false;
        }
        //============
        // 对市 区进行验证
        //============
    }

    // 验证出生日期
    private static function checkDate($date){
        if(strlen($date) == 6){
            $date1 = substr($date,0,2);
            $date2 = substr($date,2,2);
            $date3 = substr($date,4,2);
            $statusY = self::checkY('19'.$date1);
        }else{
            $date1 = substr($date,0,4);
            $date2 = substr($date,4,2);
            $date3 = substr($date,6,2);
            $nowY = date("Y",time());
            if(1900 < $date1 && $date1 <= $nowY){
                $statusY = self::checkY($date1);
            }else{
                return false;
            }
        }
        if(0<$date2 && $date2 <13){
            if($date2 == 2){
                // 润年
                if($statusY){
                    if(0 < $date3 && $date3 <= 29){
                        return true;
                    }else{
                        return false;
                    }
                }else{
                    // 平年
                    if(0 < $date3 && $date3 <= 28){
                        return true;
                    }else{
                        return false;
                    }
                }
            }else{
                $maxDateNum = self::getDateNum($date2);
                if(0<$date3 && $date3 <=$maxDateNum){
                    return true;
                }else{
                    return false;
                }
            }
        }else{
            return false;
        }
    }

    // 验证平年润年，参数年份,返回 true为润年  false为平年
    private static function checkY($Y){
        if(getType($Y) == 'string'){
            $Y = (int)$Y;
        }
        if($Y % 100 == 0){
            if($Y % 400 == 0){
                return true;
            }else{
                return false;
            }
        }else if($Y % 4 ==  0){
            return true;
        }else{
            return false;
        }
    }

    // 当月天数 参数月份（不包括2月）  返回天数
    private static function getDateNum($month){
        if($month == 1 || $month == 3 || $month == 5 || $month == 7 || $month == 8 || $month == 10 || $month == 12){
            return 31;
        }else if($month == 2){
        }else{
            return 30;
        }
    }

    // 验证性别
    private static function checkSex($sex){
        if($sex % 2 == 0){
            return false;
        }else{
            return true;
        }
    }

    // 验证18位身份证最后一位
    private static function checkEnd($num){
        $checkHou = array(1,0,'x',9,8,7,6,5,4,3,2);
        $checkGu = array(7,9,10,5,8,4,2,1,6,3,7,9,10,5,8,4,2);
        $sum = 0;
        for($i = 0;$i < 17; $i++){
            $sum += (int)$checkGu[$i] * (int)$num[$i];
        }
        $checkHouParameter= $sum % 11;
        if($checkHou[$checkHouParameter] != $num[17]){
            return false;
        }else{
            return true;
        }
    }

    /**
     * 护照验证
     * @param string $passport  护照号码
     * @return bool
     */
    public static function passportValidate($passport){
        return preg_match('/(^[a-zA-Z]{5,17}$)|(^[a-zA-Z0-9]{5,17}$)/',$passport) == 0 ? false : true;
    }

    /**
     * 秒数转换成天时分格式
     * @param int $seconds  秒数
     * @return string
     */
    public static function timeFormatStr($seconds){
        $days = floor($seconds/86400);
        $hours = floor(($seconds-$days*86400)/3600);
        $minutes = floor(($seconds-$days*86400-$hours*3600)/60);
        return "{$days}天{$hours}时{$minutes}分";
    }

    /**
     * 内容上传图片地址修复
     * @param string $content   站点详情字符
     * @return mixed
     */
    public static function addContentImageUrl($content){
        return preg_replace('/src=\"\/uploads(\/image\/\d+\/\d+\.(?:jpg|jpeg|png|gif){1})\"/i','src="'.Yii::$app->request->hostInfo.Yii::getAlias('@uploadsUrl').'${1}"',$content);
    }
}