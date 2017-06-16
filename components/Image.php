<?php
/**
 * @author: xin
 * Date: 2016/7/13
 * Time: 14:30
 */

namespace app\components;


class Image
{
    /**
     * 建立缩略图（200*200 12k左右）
     * @param string $file 输入图片地址
     * @param string $output_file 输出图片地址
     * @param int $width 宽度
     * @param int $height 高度
     * @return bool
     */
    public static function createResizeImg($file,$output_file,$width=640,$height=480){
        if(is_file($file) && is_readable($file)){//如果图片不存在或者不能读，直接返回false
            $str = file_get_contents($file);
            $src = imagecreatefromstring($str);
            $size = getimagesize($file);
            $des = imagecreatetruecolor($width,$height);
            imagecopyresized($des,$src,0,0,0,0,$width,$height,$size[0],$size[1]);
            switch($size['mime']){
                case 'image/jpeg':
                    imagejpeg($des,$output_file);
                    break;
                case 'image/png':
                    imagepng($des,$output_file);
                    break;
                case 'image/gif':
                    imagegif($des,$output_file);
                    break;
            }
            imagedestroy($src);
            imagedestroy($des);
            return is_file($output_file);
        }
        return false;
    }

    /**
     * 用字符流生成图片
     * @param string $output_file   输出文件（绝对地址）
     * @param string $stream        文件流字符
     * @param int $width            新图片宽度
     * @param int $height           新图片高度
     * @return bool
     */
    public static function createImageFromStream($output_file,$stream,$width=640,$height=480){
        $src = imagecreatefromstring($stream);
        $des = imagecreatetruecolor($width,$height);
        $size = getimagesizefromstring($stream);
        imagecopyresized($des,$src,0,0,0,0,$width,$height,$size[0],$size[1]);
        switch($size['mime']){
            case 'image/jpeg':
                imagejpeg($des,$output_file);
                break;
            case 'image/png':
                imagepng($des,$output_file);
                break;
            case 'image/gif':
                imagegif($des,$output_file);
                break;
        }
        imagedestroy($src);
        imagedestroy($des);
        return is_file($output_file);
    }
}