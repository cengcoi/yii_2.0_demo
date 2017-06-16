<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\AdminMenu */

$this->title = '菜单浏览';
$this->params['breadcrumbs'][] = ['label' => '菜单管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-menu-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('修改', ['menu-update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['menu-delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '确定删除该菜单?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'menu_text',
            'icon_alias',
            'url',
            'access_name',
            [
                'label'=>'父级',
                'value'=>'parentName',
            ],
            [
                'label'=>'显示',
                'format'=>'raw',
                'value'=>$model->is_display == 1 ? '<span style="color:green;">是</span>':'<span style="color:red;">否</span>',
            ],
            'rank',
            [
                'label'=>'系统菜单',
                'format'=>'raw',
                'value'=>$model->is_sys == 1 ? '<span style="color:green;">是</span>':'<span style="color:red;">否</span>',
            ],
        ],
    ]) ?>

</div>
