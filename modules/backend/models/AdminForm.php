<?php
/**
 * @author: xin
 * Date: 2016/8/5
 * Time: 11:48
 */

namespace app\modules\backend\models;

use Yii;
use yii\base\Model;
use app\models\Admin;

class AdminForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user = false;


    public function attributeLabels(){
        return [
            'username'   => '用户名',
            'password'   => '密码',
            'rememberMe' => '记住我',
        ];
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $admin = $this->getAdmin();

            if (!$admin || !$admin->validatePassword($this->password)) {
                $this->addError($attribute, '错误的用户名和密码。');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->admin->login($this->getAdmin(), $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }

    /**
     * 获取用户实体
     * @return Admin|array|bool|null
     */
    public function getAdmin()
    {
        if ($this->_user === false) {
            $this->_user = Admin::findByUsername($this->username);
        }

        return $this->_user;
    }
}