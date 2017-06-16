<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;
use app\components\Security;

/**
 * This is the model class for table "admin".
 *
 * @property string $id
 * @property string $username
 * @property string $password
 * @property string $salt
 * @property string $token
 * @property string $role_id
 * @property integer $is_lock
 */
class Admin extends \yii\db\ActiveRecord implements IdentityInterface
{
    const SCENARIO_ADD = 'add';
    const SCENARIO_UPDATE = 'update';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password', 'salt','role_id'], 'required'],
            [['username'],'unique'],
            [['role_id', 'is_lock'], 'integer'],
            [['username'], 'string', 'max' => 20],
            [['password'], 'string', 'max' => 60],
            [['salt'], 'string', 'max' => 29],
            [['token'], 'string', 'max' => 64],
            [['username'], 'unique'],
        ];
    }

    public function scenarios(){
        return [
            'add'=>['username', 'password', 'salt','role_id'],
            'update'=>['role_id']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '管理员ID',
            'username' => '用户名',
            'password' => '密码',
            'salt' => '随机码',
            'token' => '验证令牌',
            'role_id' => '角色ID',
            'is_lock' => '是否锁定',
        ];
    }

    /**
     * @inheritdoc
     * @return AdminQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AdminQuery(get_called_class());
    }

    /**
     * 角色名称
     * @return string
     */
    public function getRoleName(){
        $role = AdminRole::findOne($this->role_id);
        return $role ? $role->role_name : '未知角色';
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return md5(substr($this->salt,10));
    }

    /**
     * 验证authKey
     * @param string $authKey
     * @return bool
     */
    public function validateAuthKey($authKey)
    {
        return md5(substr($this->salt,10)) === $authKey;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null){
        return self::find()->validAdminByToken($token)->one();
    }

    /**
     * 通过用户名查找后台用户
     * @param $username
     * @return Admin|array|null
     */
    public static function findByUsername($username)
    {
        return static::find()->validAdminByUsername($username)->one();
    }

    /**
     * 验证密码
     * @param string $password  原始密码
     * @return bool
     */
    public function validatePassword($password){
        return $this->password === Security::getHash($password,$this->salt);
    }
}
