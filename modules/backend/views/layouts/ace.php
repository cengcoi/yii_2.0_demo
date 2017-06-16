<?php
/**
 * @author: xin
 * Date: 2016/7/8
 * Time: 17:35
 */

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\assets\AceAsset;
use yii\helpers\Url;
use app\models\AdminMenuModel;

$menu = new AdminMenuModel();
$person_menu = $menu->person_menu();

AceAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body class="no-skin">
    <?php $this->beginBody() ?>
    <!-- #section:basics/navbar.layout -->
    <div id="navbar" class="navbar navbar-default">
        <script type="text/javascript">
            try {
                ace.settings.check('navbar', 'fixed')
            } catch (e) {
            }
        </script>

        <div class="navbar-container" id="navbar-container">
            <!-- #section:basics/sidebar.mobile.toggle -->
            <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler">
                <span class="sr-only">Toggle sidebar</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <!-- /section:basics/sidebar.mobile.toggle -->

            <div class="navbar-header pull-left">
                <!-- #section:basics/navbar.layout.brand -->
                <a href="#" class="navbar-brand">
                    <small>
                        <i class="fa fa-leaf"></i>
                        <?php echo Html::encode(Yii::$app->name); ?>后台 － 美骑网|Biketo.com
                    </small>
                </a>
                <!-- /section:basics/navbar.layout.brand -->
            </div>

            <!-- #section:basics/navbar.dropdown -->
            <div class="navbar-buttons navbar-header pull-right" role="navigation">
                <ul class="nav ace-nav">
                    <!-- #section:basics/navbar.user_menu -->
                    <li class="green">
                        <a target="_blank" href="/">
                            <i class="ace-icon fa fa-home"></i>
                            <span>前台首页</span>
                        </a>
                    </li>
                    <li class="light-blue">
                        <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                            <span class="user-info">
                                <small>欢迎，</small>
                                <?= Yii::$app->admin->identity->username ?>
                            </span>
                            <i class="ace-icon fa fa-caret-down"></i>
                        </a>

                        <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                            <?php if(Yii::$app->admin->identity->role_id == 1) { ?>
                                <li>
                                    <a href="#" id="clear_cache">
                                        <i class="ace-icon fa fa-cog"></i>
                                        清除缓存
                                    </a>
                                </li>
                            <?php } ?>
                            <li>
                                <a href="<?= Url::toRoute(['base/re-password'])?>" id="clear_cache">
                                    <i class="ace-icon fa fa-cog"></i>
                                    修改密码
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <?= Html::beginForm(['/backend/default/logout'], 'post', ['class' => 'navbar-form']) ?>
                                <?= Html::submitButton('登出 (' . Yii::$app->admin->identity->username . ')<i class="ace-icon fa fa-power-off"></i>', ['class' => 'btn btn-link']); ?>
                                <?= Html::endForm() ?>
                            </li>
                        </ul>
                    </li>
                    <!-- /section:basics/navbar.user_menu -->
                </ul>
            </div>

            <!-- /section:basics/navbar.dropdown -->
        </div>
        <!-- /.navbar-container -->
    </div>

    <!-- /section:basics/navbar.layout -->
    <div class="main-container" id="main-container">
        <script type="text/javascript">
            try {
                ace.settings.check('main-container', 'fixed')
            } catch (e) {
            }
        </script>
        <!-- #section:basics/sidebar -->
        <div id="sidebar" class="sidebar responsive">
            <script type="text/javascript">
                try {
                    ace.settings.check('sidebar', 'fixed')
                } catch (e) {
                }
            </script>

            <ul class="nav nav-list">
                <li<?php echo Yii::$app->controller->id == 'default' ? ' class="active"':'' ?>>
                    <a href="<?=Url::toRoute('base/base-index')?>">
                        <i class="menu-icon fa fa-tachometer"></i>
                        <span class="menu-text"> 后台总概 </span>
                    </a>
                    <b class="arrow"></b>
                </li>
                <?php if(Yii::$app->admin->identity->role_id == 1) { ?>
                <li<?php echo Yii::$app->controller->id == 'admin' ? ' class="active"':'' ?>>
                    <a href="#" class="dropdown-toggle">
                        <i class="menu-icon fa fa-cogs"></i>
                        <span class="menu-text"> 系统管理 </span>
                        <b class="arrow fa fa-angle-down"></b>
                    </a>
                    <b class="arrow"></b>
                    <ul class="submenu">
                        <li<?php echo Yii::$app->controller->id == 'admin' && Yii::$app->controller->action->id == 'index' ? ' class="active"':'' ?>>
                            <a href="<?=Url::toRoute('admin/index')?>">
                                <i class="menu-icon fa fa-caret-right"></i>
                                后台用户管理
                            </a>
                            <b class="arrow"></b>
                        </li>
                        <li<?php echo Yii::$app->controller->id == 'admin' && Yii::$app->controller->action->id == 'access-index' ? ' class="active"':'' ?>>
                            <a href="<?=Url::toRoute('admin/access-index')?>">
                                <i class="menu-icon fa fa-caret-right"></i>
                                权限项管理
                            </a>
                            <b class="arrow"></b>
                        </li>
                        <li<?php echo Yii::$app->controller->id == 'admin' && Yii::$app->controller->action->id == 'menu-index' ? ' class="active"':'' ?>>
                            <a href="<?=Url::toRoute('admin/menu-index')?>">
                                <i class="menu-icon fa fa-caret-right"></i>
                                菜单管理
                            </a>
                            <b class="arrow"></b>
                        </li>
                        <li<?php echo Yii::$app->controller->id == 'admin' && Yii::$app->controller->action->id == 'role-index' ? ' class="active"':'' ?>>
                            <a href="<?=Url::toRoute('admin/role-index')?>">
                                <i class="menu-icon fa fa-caret-right"></i>
                                角色管理
                            </a>
                            <b class="arrow"></b>
                        </li>
                    </ul>
                </li>
                <?php } ?>
                <?php if(isset($person_menu) && $person_menu) { ?>
                <?php foreach($person_menu as $v) { ?>
                    <li<?php if(isset($v['child'])){echo Yii::$app->controller->id == $v['access_name'] ? ' class="active open"' : '';}else{echo Yii::$app->controller->id == $v['access_name'] ? ' class="active"' : '';} ?>>
                        <a <?php echo !isset($v['child']) ? 'href="'.Url::toRoute($v['url']).'"' : 'href="#" class="dropdown-toggle"'; ?>>
                            <i class="menu-icon fa fa-<?php echo $v['icon_alias'];?>"></i>
                            <span class="menu-text"> <?php echo $v['menu_text'];?> </span>
                            <?php if(isset($v['child'])) : ?><b class="arrow fa fa-angle-down"></b><?php endif;?>
                        </a>

                        <b class="arrow"></b>
                        <?php if(isset($v['child'])) : ?>
                            <ul class="submenu">
                                <?php foreach($v['child'] as $v) {?>
                                    <li<?php if (Yii::$app->controller->id.'_'.Yii::$app->controller->action->id == $v['access_name']) : echo ' class="active"'; endif; ?>>
                                        <a href="<?=Url::toRoute($v['url'])?>">
                                            <i class="menu-icon fa fa-<?php echo $v['icon_alias'];?>"></i>
                                            <?php echo $v['menu_text'];?>
                                        </a>

                                        <b class="arrow"></b>
                                    </li>
                                <?php } ?>
                            </ul>
                        <?php endif;?>
                    </li>
                <?php }  } ?>
            </ul>
            <!-- /.nav-list -->

            <!-- #section:basics/sidebar.layout.minimize -->
            <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
                <i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left"
                   data-icon2="ace-icon fa fa-angle-double-right"></i>
            </div>

            <!-- /section:basics/sidebar.layout.minimize -->
            <script type="text/javascript">
                try {
                    ace.settings.check('sidebar', 'collapsed')
                } catch (e) {
                }
            </script>
        </div>
        <!-- /section:basics/sidebar -->

        <!-- .main-content -->
        <div class="main-content">
            <!-- #section:basics/content.breadcrumbs -->
            <div class="breadcrumbs" id="breadcrumbs">
                <script type="text/javascript">
                    try {
                        ace.settings.check('breadcrumbs', 'fixed')
                    } catch (e) {
                    }
                </script>

                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>

            </div>

            <!-- /section:basics/content.breadcrumbs -->
            <div class="page-content">
                <div class="page-content-area">

                    <div class="row">
                        <div class="col-xs-12">
                            <!-- PAGE CONTENT BEGINS -->
                            <?php echo $content;?>
                            <!-- PAGE CONTENT ENDS -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.page-content-area -->
            </div>
            <!-- /.page-content -->
        </div>
        <!-- /.main-content -->

        <div class="footer">
            <div class="footer-inner">
                <!-- #section:basics/footer -->
                <div class="footer-content">
                <span class="bigger-120">
                    <span class="blue bolder">Biketo.com</span>
                    Backend &copy; <?php echo date('Y');?>
                </span>
                </div>

                <!-- /section:basics/footer -->
            </div>
        </div>

        <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
            <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
        </a>

    </div>
    <!-- /.main-container -->

    <?php $this->registerJs('
        function notice_show(title,text){
            $.gritter.add({
                title: title ? title : "消息",
                text: text,
                class_name: "gritter-info gritter-center"
            });
        }
    ',\yii\web\View::POS_END);

    if(Yii::$app->admin->identity->role_id == 1) {
        $this->registerJs('
            $("#clear_cache").on("click",function(){
                $.get("'.Url::toRoute(['base/clear-cache']).'",function(r){
                    if(r==1)
                        notice_show("成功","成功清除缓存！");
                    else if (r==0)
                        notice_show("失败","清除缓存失败，请稍后再试！");
                });
            });
        ',\yii\web\View::POS_END);
    }
    ?>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>