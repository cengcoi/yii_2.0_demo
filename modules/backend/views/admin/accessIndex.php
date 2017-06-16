<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\models\AdminAccessModel */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '权限项管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-access-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('增加权限项', ['access-create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [

                'id',
                'access_name',
                'description',
                [
                    'header'=>'父级',
                    'value'=>function($model){
                        return $model->parentName;
                    },
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'buttons' => [
                        'view'=>function($url,$model,$key){
                            $options = [
                                'title' => Yii::t('yii', 'View'),
                                'aria-label' => Yii::t('yii', 'View'),
                                'data-pjax' => '0',
                            ];
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', Url::toRoute(['admin/access-view','id'=>$model->id]), $options);
                        },
                        'update'=>function($url,$model,$key){
                            $options = [
                                'title' => Yii::t('yii', 'Update'),
                                'aria-label' => Yii::t('yii', 'Update'),
                                'data-pjax' => '0',
                            ];
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Url::toRoute(['admin/access-update','id'=>$model->id]), $options);
                        },
                        'delete'=>function($url,$model,$key){
                            $options = [
                                'title' => Yii::t('yii', 'Delete'),
                                'aria-label' => Yii::t('yii', 'Delete'),
                                'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                'data-method' => 'post',
                                'data-pjax' => '0',
                            ];
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', Url::toRoute(['admin/access-delete','id'=>$model->id]), $options);
                        }
                    ],
                ],
            ],
        ]); ?>
    <?php Pjax::end(); ?>
</div>
