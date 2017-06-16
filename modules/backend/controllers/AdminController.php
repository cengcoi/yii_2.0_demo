<?php

namespace app\modules\backend\controllers;

use Yii;
use app\models\Admin;
use app\models\AdminModel;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\AdminAccess;
use app\models\AdminAccessModel;
use app\models\AdminMenu;
use app\models\AdminMenuModel;
use app\models\AdminRole;
use app\models\AdminRoleModel;
use app\components\Security;

/**
 * AdminController implements the CRUD actions for Admin model.
 */
class AdminController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'access-delete' => ['POST'],
                    'menu-delete' => ['POST'],
                    'role-delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Admin models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AdminModel();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Admin model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Admin model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Admin(['scenario' => 'add']);

        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post('Admin');
            $model->username = $data['username'];
            $model->role_id = $data['role_id'];
            $security = Security::generateHash($data['password']);
            $model->password = $security['password'];
            $model->salt = $security['salt'];
            $model->token = md5(substr($security['salt'],10));
            if($model->save())
                return $this->redirect(['view', 'id' => $model->id]);
        }

        $model->password = '';//清空密码操作，防止验证失败后把加密值赋值到表单
        return $this->render('create', [
            'model' => $model,
            'roleSelect' => AdminRoleModel::roleSelect(),
        ]);
    }

    /**
     * Updates an existing Admin model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = 'update';

        if(Yii::$app->request->isPost){
            $data = Yii::$app->request->post('Admin');
            if(!empty($data['password'])){
                $security = Security::generateHash($data['password']);
                $model->password = $security['password'];
                $model->salt = $security['salt'];
                $model->token = md5(substr($security['salt'],10));
            }
            $model->role_id = (int)$data['role_id'];
            if($model->save())
                return $this->redirect(['view', 'id' => $model->id]);
        }
        $model->password = '';//初始化密码不进行填写
        return $this->render('update', [
            'model' => $model,
            'roleSelect' => AdminRoleModel::roleSelect(),
        ]);
    }

    /**
     * Deletes an existing Admin model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Admin model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Admin the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Admin::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Lists all AdminAccess models.
     * @return mixed
     */
    public function actionAccessIndex()
    {
        $searchModel = new AdminAccessModel();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('accessIndex', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AdminAccess model.
     * @param string $id
     * @return mixed
     */
    public function actionAccessView($id)
    {
        return $this->render('accessView', [
            'model' => $this->findAccessModel($id),
        ]);
    }

    /**
     * Creates a new AdminAccess model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAccessCreate()
    {
        $model = new AdminAccess();
        $AdminAccessModel = new AdminAccessModel();
        $parentAccess = $AdminAccessModel->parentAccess();//排除自身的父级

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['access-view', 'id' => $model->id]);
        } else {
            return $this->render('accessCreate', [
                'model' => $model,
                'parentAccess'=>$parentAccess,
            ]);
        }
    }

    /**
     * Updates an existing AdminAccess model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionAccessUpdate($id)
    {
        $model = $this->findAccessModel($id);
        $AdminAccessModel = new AdminAccessModel();
        $parentAccess = $AdminAccessModel->parentAccess($id);//排除自身的父级

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['access-view', 'id' => $model->id]);
        } else {
            return $this->render('accessUpdate', [
                'model' => $model,
                'parentAccess'=>$parentAccess,
            ]);
        }
    }

    /**
     * Deletes an existing AdminAccess model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionAccessDelete($id)
    {
        $this->findAccessModel($id)->delete();

        return $this->redirect(['access-index']);
    }

    /**
     * Finds the AdminAccess model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return AdminAccess the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findAccessModel($id)
    {
        if (($model = AdminAccess::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Lists all AdminMenu models.
     * @return mixed
     */
    public function actionMenuIndex()
    {
        $searchModel = new AdminMenuModel();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('menuIndex', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AdminMenu model.
     * @param string $id
     * @return mixed
     */
    public function actionMenuView($id)
    {
        return $this->render('menuView', [
            'model' => $this->findMenuModel($id),
        ]);
    }

    /**
     * Creates a new AdminMenu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionMenuCreate()
    {
        $model = new AdminMenu();
        $parentMenu = AdminMenuModel::parentMenu();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['menu-view', 'id' => $model->id]);
        } else {
            return $this->render('menuCreate', [
                'model' => $model,
                'parentMenu' => $parentMenu,
            ]);
        }
    }

    /**
     * Updates an existing AdminMenu model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionMenuUpdate($id)
    {
        $model = $this->findMenuModel($id);

        $parentMenu = AdminMenuModel::parentMenu($id);//排除自身的所有父级ID
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['menu-view', 'id' => $model->id]);
        } else {
            return $this->render('menuUpdate', [
                'model' => $model,
                'parentMenu' => $parentMenu,
            ]);
        }
    }

    /**
     * Deletes an existing AdminMenu model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionMenuDelete($id)
    {
        $this->findMenuModel($id)->delete();

        return $this->redirect(['menu-index']);
    }

    /**
     * Finds the AdminMenu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return AdminMenu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findMenuModel($id)
    {
        if (($model = AdminMenu::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    /**
     * Lists all AdminRole models.
     * @return mixed
     */
    public function actionRoleIndex()
    {
        $searchModel = new AdminRoleModel();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('roleIndex', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AdminRole model.
     * @param integer $id
     * @return mixed
     */
    public function actionRoleView($id)
    {
        $access = new AdminAccessModel;
        $access_tree = $access->accessTree();

        return $this->render('roleView', [
            'model' => $this->findRoleModel($id),
            'access_tree'=>$access_tree,
        ]);
    }

    /**
     * Creates a new AdminRole model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionRoleCreate()
    {
        $model = new AdminRole();
        $access = new AdminAccessModel;
        $access_tree = $access->accessTree();

        if(Yii::$app->request->isPost){
            $data = Yii::$app->request->post();
            $model->role_name = $data['AdminRole']['role_name'];
            $model->access = '';
            if($model->save())
                return $this->redirect(['role-view', 'id' => $model->id]);
        }

        return $this->render('roleCreate', [
            'model' => $model,
            'access_tree' => $access_tree,
        ]);
    }

    /**
     * Updates an existing AdminRole model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionRoleUpdate($id)
    {
        $model = $this->findRoleModel($id);
        $access = new AdminAccessModel;
        $access_tree = $access->accessTree();

        if(Yii::$app->request->isPost){
            $data = Yii::$app->request->post();
            $model->access = isset($data['access']) && $data['access'] ? implode(',',$data['access']) : '';
            if($model->save())
                return $this->redirect(['role-view', 'id' => $model->id]);
        }

        return $this->render('roleUpdate', [
            'model' => $model,
            'access_tree' => $access_tree,
        ]);
    }

    /**
     * Deletes an existing AdminRole model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionRoleDelete($id)
    {
        $this->findRoleModel($id)->delete();

        return $this->redirect(['role-index']);
    }

    /**
     * Finds the AdminRole model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AdminRole the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findRoleModel($id)
    {
        if (($model = AdminRole::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
