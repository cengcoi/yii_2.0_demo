<?php

namespace app\modules\backend\controllers;

use app\modules\backend\models\AdminForm;
use Yii;
use yii\web\Controller;

/**
 * Default controller for the `backend` module
 */
class DefaultController extends Controller
{

    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * 登录页面
     * @return string|\yii\web\Response
     */
    public function actionLogin(){
        $this->layout = 'login';

        if (!Yii::$app->admin->isGuest) {
            return $this->redirect(['base/base-index']);
        }

        $model = new AdminForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['base/base-index']);
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * 退出操作
     */
    public function actionLogout(){
        Yii::$app->admin->logout();
        $this->redirect(['default/login']);
    }
}
