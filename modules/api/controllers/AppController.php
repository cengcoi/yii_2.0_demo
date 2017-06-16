<?php
/**
 * API接口基类（进行token验证和用户资料检测）
 * @author: xin
 * Date: 2016/6/27
 * Time: 9:27
 */
namespace app\modules\api\controllers;

use app\components\Token;
use Yii;
use yii\web\Controller;
use yii\base\Object;

class AppController extends Controller
{
    public $enableCsrfValidation = false;//接口不进行csrf检测
    protected $_member = [];

    public function beforeAction($action){
        return parent::beforeAction($action);
    }

    /**
     * 检测用户验证令牌
     */
    protected function checkToken(){
        $token = Yii::$app->request->get('token');
        if(is_null($token)||empty($token))
            return $this->unauthorized();
		$token = str_replace(" ", "+", $token);
        $data = Token::decode($token);
        if(!$data)
            return $this->tokenError();

        $member_id = (int)$data['member_id'];

        $member = [];
        if(!$member)
            return $this->unauthorized();

        $this->_member = $member;
    }

    /**
     * API模块默认错误返回内容
     */
    public function actionError(){
        $handler = Yii::$app->errorHandler;
        return $this->returnJson(['status'=>$handler->exception->statusCode,'message'=>$handler->exception->getMessage(),'error'=>new Object(),'data'=>new Object()]);
    }

    /**
     * Token错误
     */
    protected function tokenError(){
        return $this->returnJson(['status'=>1000,'message'=>'Token错误。','error'=>new Object(),'data'=>['login_url'=>Yii::$app->params['UC_OAUTH_URL'].'?client_id='.Yii::$app->params['UC_CLIENT_ID'].'&type=login&t=redbull']]);
    }

    /**
     * 未授权，需要登录
     */
    protected function unauthorized(){
        return $this->returnJson(['status'=>401,'message'=>'未授权，请登录。','error'=>new Object(),'data'=>['login_url'=>Yii::$app->params['UC_OAUTH_URL'].'?client_id='.Yii::$app->params['UC_CLIENT_ID'].'&type=login&t=redbull']]);
    }
    /**
     * 403禁止
     */
    protected function forbidden(){
        return $this->returnJson(['status'=>403,'message'=>'被禁止。','error'=>new Object(),'data'=>new Object()]);
    }

    /**
     * 404未找到
     */
    protected function notFound(){
        return $this->returnJson(['status'=>404,'message'=>'找不到该数据。','error'=>new Object(),'data'=>new Object()]);
    }

    /**
     * 返回统一方法
     * @param string|array $data    返回数据
     */
    protected function returnJson($data){
        exit(json_encode($data));
    }

    /**
     * 检测必要的Post参数
     * @param array $names  post数据key名称数组
     */
    protected function requiredPostData($names){
        $postArr = Yii::$app->request->post();
        foreach($names as $name){
            if(!isset($postArr[$name]))
                return $this->returnJson(['status'=>2,'message'=>'key为('.$name.') 的post数据缺少','error'=>new Object(),'data'=>new Object()]);
        }
    }

    /**
     * 检查必要的Get参数
     * @param array $names  get数据key名称数组
     */
    protected function requiredGetData($names){
        $postArr = Yii::$app->request->get();
        foreach($names as $name){
            if(!isset($postArr[$name]))
                return $this->returnJson(['status'=>2,'message'=>'key为('.$name.') 的get数据缺少','error'=>new Object(),'data'=>new Object()]);
        }
    }
}