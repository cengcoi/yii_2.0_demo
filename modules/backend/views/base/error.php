<?php
/**
 * @author: xin
 * Date: 2016/8/9
 * Time: 13:31
 */

use yii\helpers\Url;
use yii\helpers\Html;

?>

<div class="error-container">
    <div class="well">
        <h1 class="grey lighter smaller">
		    <span class="blue bigger-125">
		    	<i class="ace-icon fa fa-sitemap"></i>
                <?= $error->exception->statusCode ?>
            </span>
            <?= Html::encode($error->exception->getMessage())?>
        </h1>

        <hr>
        <div>
            <div class="space"></div>
            <h4 class="smaller">一定是你的姿势不对，请尝试以下动作：</h4>

            <ul class="list-unstyled spaced inline bigger-110 margin-15">
                <li>
                    <i class="ace-icon fa fa-hand-o-right blue"></i>
                    查看输入的URL
                </li>

                <li>
                    <i class="ace-icon fa fa-hand-o-right blue"></i>
                    联系管理员
                </li>
            </ul>
        </div>

        <hr>
        <div class="space"></div>

        <div class="center">
            <a href="javascript:history.back()" class="btn btn-grey">
                <i class="ace-icon fa fa-arrow-left"></i>
                返回
            </a>

            <a href="<?= Url::toRoute(['base/index'])?>" class="btn btn-primary">
                <i class="ace-icon fa fa-home"></i>
                后台首页
            </a>
        </div>
    </div>
</div>
