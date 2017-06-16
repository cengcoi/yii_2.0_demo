<?php
/**
 * @author: xin
 * Date: 2016/7/12
 * Time: 19:03
 */

namespace app\assets;
use yii\web\AssetBundle;

class LoginAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'ace/assets/css/bootstrap.min.css',
        'ace/assets/css/font-awesome.min.css',
        'ace/assets/css/ace-fonts.css',
        'ace/assets/css/ace.min.css',
        'ace/assets/css/ace-part2.min.css',
        'ace/assets/css/ace-rtl.min.css',
        'ace/assets/css/ace-ie.min.css',
    ];
    public $js = [
        'ace/assets/js/ace-extra.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
