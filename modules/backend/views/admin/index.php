<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\AdminModel */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '后台用户管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('增加后台用户', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                'id',
                'username',
                'roleName',
                [
                    'header'=>'是否锁定',
                    'format'=>'raw',
                    'value'=>function($model){
                        return $model->is_lock == 1 ? '<span style="color:red;">锁定</span>':'<span style="color:green;">正常</span>';
                    }
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'visibleButtons'=>[
                        'delete'=>function($model){
                            return $model->id !=1 ? true:false;
                        },
                    ]
                ],
            ],
        ]); ?>
    <?php Pjax::end(); ?>
</div>
