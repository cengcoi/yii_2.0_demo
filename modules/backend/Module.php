<?php

namespace app\modules\backend;

/**
 * backend module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\backend\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
        \Yii::$app->errorHandler->errorAction = 'backend/base/error';
        \Yii::$app->setComponents([
            'admin' => [
                'class'=>'\yii\web\User',
                'identityClass' => 'app\models\Admin',
                'enableAutoLogin' => true,
                'loginUrl' => ['backend/default/login'],
            ],
        ]);
    }
}
