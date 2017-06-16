<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\AdminRole */

$this->title = '浏览角色';
$this->params['breadcrumbs'][] = ['label' => '角色管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-role-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if($model->id != 1) { ?>
    <p>
        <?= Html::a('修改', ['role-update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['role-delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '确定要删除该角色吗?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?php } ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'role_name',
        ],
    ]) ?>

</div>
