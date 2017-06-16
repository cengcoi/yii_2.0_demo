<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AdminRoleModel */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '角色管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-role-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('增加角色', ['role-create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                'role_name',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'buttons' => [
                        'view'=>function($url,$model,$key){
                            $options = [
                                'title' => Yii::t('yii', 'View'),
                                'aria-label' => Yii::t('yii', 'View'),
                                'data-pjax' => '0',
                            ];
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', Url::toRoute(['admin/role-view','id'=>$model->id]), $options);
                        },
                        'update'=>function($url,$model,$key){
                            $options = [
                                'title' => Yii::t('yii', 'Update'),
                                'aria-label' => Yii::t('yii', 'Update'),
                                'data-pjax' => '0',
                            ];
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Url::toRoute(['admin/role-update','id'=>$model->id]), $options);
                        },
                        'delete'=>function($url,$model,$key){
                            $options = [
                                'title' => Yii::t('yii', 'Delete'),
                                'aria-label' => Yii::t('yii', 'Delete'),
                                'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                'data-method' => 'post',
                                'data-pjax' => '0',
                            ];
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', Url::toRoute(['admin/role-delete','id'=>$model->id]), $options);
                        }
                    ],
                    'visibleButtons'=>[
                        'update'=>function($model){
                            return $model->id !=1 ? true:false;
                        },
                        'delete'=>function($model){
                            return $model->id !=1 ? true:false;
                        },
                    ]
                ],
            ],
        ]); ?>
    <?php Pjax::end(); ?>
</div>
