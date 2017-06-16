<?php
/**
 * @author: xin
 * Date: 2016/8/15
 * Time: 11:59
 */

namespace app\modules\backend\models;

use app\components\Security;
use Yii;
use yii\base\Model;
use app\models\Admin;

class PasswordForm extends Model
{
    public $oldPassword;
    public $rePassword;
    public $rePasswordConfirm;
    protected $_user = false;

    public function attributeLabels(){
        return [
            'oldPassword'   => '旧密码',
            'rePassword'   => '新密码',
            'rePasswordConfirm' => '密码确认',
        ];
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['oldPassword', 'rePassword', 'rePasswordConfirm'], 'required'],
            [['rePasswordConfirm'], 'checkConfirm'],
            // password is validated by validatePassword()
            ['oldPassword', 'validatePassword'],
        ];
    }

    public function checkConfirm($attribute, $params){
        if(!$this->hasErrors()){
            if($this->rePassword !== $this->rePasswordConfirm)
                $this->addError($attribute,'新密码与密码确认必须要一致');
        }
    }

    /**
     * @param $attribute
     * @param $params
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $admin = $this->getAdmin();

            if (!$admin || !$admin->validatePassword($this->oldPassword)) {
                $this->addError($attribute, '原始密码错误');
            }
        }
    }

    /**
     * 修改密码
     * @return bool
     */
    public function changePassword(){

        if ($this->validate()) {
            $admin = $this->getAdmin();
            $security = Security::generateHash($this->rePassword);

            $admin->password = $security['password'];
            $admin->salt = $security['salt'];
            $admin->token = md5(substr($security['salt'], 10));

            $admin->scenario = 'update';
            return $admin->save();
        }
        return false;
    }

    /**
     * 获取当前用户
     * @return null|static
     */
    public function getAdmin()
    {
        if ($this->_user === false) {
            $this->_user = Admin::findOne(Yii::$app->admin->identity->id);
        }

        return $this->_user;
    }
}