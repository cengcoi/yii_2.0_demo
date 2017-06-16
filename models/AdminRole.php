<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "admin_role".
 *
 * @property integer $id
 * @property string $role_name
 * @property string $access
 */
class AdminRole extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin_role';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['role_name'], 'required'],
            [['access'], 'string'],
            [['role_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '角色ID',
            'role_name' => '角色名字',
            'access' => '赋值字符',
        ];
    }

    /**
     * @inheritdoc
     * @return AdminRoleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AdminRoleQuery(get_called_class());
    }
}
