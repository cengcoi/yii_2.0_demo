<?php
/**
 * @author: xin
 * Date: 2016/8/5
 * Time: 11:04
 */

namespace app\components;


use yii\base\ErrorException;

class Dir {
    /**
     * 生成目录
     * @param string $root  根目录路径
     * @param string $path  新生成目录路径
     * @return bool
     * @throws ErrorException
     */
    public static function DirMake($root,$path){
        if(!is_readable($root))
            throw new ErrorException($root.'根目录不可写。','403');
        $path_arr = strpos($path,'/') !== false ? explode('/',$path) : [$path];
        if($path_arr){
            $cur_dir = $root;
            foreach($path_arr as $dir){
                $cur_dir .= '/'.$dir;
                if(!is_dir($cur_dir))
                    mkdir($cur_dir,0777);
            }
        }
        return is_dir($root.$path) ? true : false;
    }
}