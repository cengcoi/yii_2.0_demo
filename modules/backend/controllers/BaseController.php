<?php
/**
 * @author: xin
 * Date: 2016/8/5
 * Time: 11:37
 */

namespace app\modules\backend\controllers;

use app\models\Admin;
use app\models\AdminAccess;
use app\models\AdminRoleModel;
use app\modules\backend\models\PasswordForm;
use Yii;
use yii\web\Controller;
use yii\web\HttpException;

class BaseController extends Controller
{
    public $layout = 'ace';

    public function beforeAction($action){
        if(Yii::$app->admin->isGuest)//检测是否登录
            return $this->redirect(['default/login'])->send();

        if($this->checkAccess($action))
            return parent::beforeAction($action);
        else{
            throw new HttpException(403,'没有权限，一定是你的姿势不对，去贿赂管理员请求权限！');
            return FALSE;
        }
    }

    protected function checkAccess($action){
        $controller = $action->controller->id;
        $action = $action->controller->action->id;

        //忽略控制器，直接通过
        if(Yii::$app->params['ignoreControllers'] && in_array($controller,Yii::$app->params['ignoreControllers']))
            return TRUE;
        else if(Yii::$app->admin->identity->role_id == 1)//管理员直接通过
            return TRUE;

        $item_name = $controller.'_'.$action;
        return $this->checkPrivilege($item_name);
    }

    protected function checkPrivilege($item_name){
        $item = AdminAccess::find()->where('access_name=:access_name',[':access_name'=>$item_name])->one();
        if($item){
            $item_id = $item->id;
            $role_access = AdminRoleModel::roleAccess(Yii::$app->admin->identity->role_id);
            if(!$role_access){
                throw new HttpException(403,'没有权限，一定是你的姿势不对，去贿赂管理员请求权限！');
                return FALSE;
            }
            if(!in_array($item_id,explode(',',$role_access['access']))){
                throw new HttpException(403,'没有权限，一定是你的姿势不对，去贿赂管理员请求权限！');
                return FALSE;
            }else
                return TRUE;
        }else {
            throw new HttpException(403,'没有权限，一定是你的姿势不对，去贿赂管理员请求权限！');
            return FALSE;
        }
    }

    /**
     * 后台首页
     * @return string
     */
    public function actionBaseIndex(){
        $role = AdminRoleModel::roleAccess(2);//生成了角色缓存数据，测试清除缓存
        return $this->render('index');
    }

    public function actionRePassword(){
        $model =  new PasswordForm;

        if($model->load(Yii::$app->request->post()) && $model->changePassword()){
            return $this->render('msg',[
                'msg'=>'修改密码成功',
            ]);
        }

        return $this->render('rePassword',['model'=>$model]);
    }

    /**
     * 错误页面
     * @return string
     */
    public function actionError(){
        $error = Yii::$app->errorHandler;
        return $this->render('error',
            ['error'=>$error]
        );
    }

    /**
     * 清除文件缓存操作
     */
    public function actionClearCache(){
        $r = Yii::$app->filecache->flush();
        $code = $r ? '1':'0';
        exit($code);
    }
}