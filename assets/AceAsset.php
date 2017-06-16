<?php
/**
 * @author: xin
 * Date: 2016/7/8
 * Time: 17:43
 */

namespace app\assets;


use yii\web\AssetBundle;

class AceAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'ace/assets/css/font-awesome.min.css',
        'ace/assets/css/ace-fonts.css',
        'ace/assets/css/jquery.gritter.css',
        'ace/assets/css/ace.min.css',
        'ace/assets/css/ace-skins.min.css',
        'ace/assets/css/ace-rtl.min.css',
    ];
    public $js = [
        'ace/assets/js/ace-extra.min.js',
        'ace/assets/js/bootstrap.min.js',
        'ace/assets/js/jquery-ui.custom.min.js',
        'ace/assets/js/jquery.ui.touch-punch.min.js',
        'ace/assets/js/jquery.gritter.min.js',
        'ace/assets/js/ace-elements.min.js',
        'ace/assets/js/ace.min.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

    //定义按需加载JS方法，注意加载顺序在最后
    public static function addScript($view, $jsFile) {
        $view->registerJsFile($jsFile, [AppAsset::className(), 'depends'=>'app\assets\AceAsset']);
    }

    //定义按需加载css方法，注意加载顺序在最后
    public static function addCss($view, $cssFile) {
        $view->registerCssFile($cssFile, [AppAsset::className(), 'depends'=>'app\assets\AceAsset']);
    }
}