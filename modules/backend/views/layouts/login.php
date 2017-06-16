<?php
/**
 * @author: xin
 * Date: 2016/7/12
 * Time: 19:11
 */

/* @var $this \yii\web\View */
/* @var $content string */


use yii\helpers\Html;
use app\assets\LoginAsset;

LoginAsset::register($this)

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta charset="utf-8"/>
    <title>登录</title>
    <meta name="description" content=""/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
    <?php $this->head() ?>
</head>

<body class="login-layout light-login">
<?php $this->beginBody() ?>
<div class="main-container">
    <div class="main-content">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <div class="login-container">
                    <?=$content ?>
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.main-content -->
</div>
<!-- /.main-container -->
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>