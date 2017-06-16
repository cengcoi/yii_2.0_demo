<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\models\AdminMenuModel */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '菜单管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-menu-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('增加菜单', ['menu-create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [

                'id',
                'menu_text',
                'icon_alias',
                'url',
                'access_name',
                [
                    'header'=>'父级',
                    'value'=>'parentName',
                ],
                [
                    'header'=>'显示',
                    'format'=>'raw',
                    'value'=>function($model){
                        return $model->is_display == 1 ? '<span style="color:green;">是</span>':'<span style="color:red;">否</span>';
                    }
                ],
                'rank',
                [
                    'header'=>'系统菜单',
                    'format'=>'raw',
                    'value'=>function($model){
                        return $model->is_sys == 1 ? '<span style="color:green;">是</span>':'<span style="color:red;">否</span>';
                    }
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
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', Url::toRoute(['admin/menu-view','id'=>$model->id]), $options);
                        },
                        'update'=>function($url,$model,$key){
                            $options = [
                                'title' => Yii::t('yii', 'Update'),
                                'aria-label' => Yii::t('yii', 'Update'),
                                'data-pjax' => '0',
                            ];
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Url::toRoute(['admin/menu-update','id'=>$model->id]), $options);
                        },
                        'delete'=>function($url,$model,$key){
                            $options = [
                                'title' => Yii::t('yii', 'Delete'),
                                'aria-label' => Yii::t('yii', 'Delete'),
                                'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                'data-method' => 'post',
                                'data-pjax' => '0',
                            ];
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', Url::toRoute(['admin/menu-delete','id'=>$model->id]), $options);
                        }
                    ],
                ],
            ],
        ]); ?>
    <?php Pjax::end(); ?>
</div>
