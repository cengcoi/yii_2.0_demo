<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "admin_access".
 *
 * @property string $id
 * @property string $access_name
 * @property string $description
 * @property integer $parent_id
 */
class AdminAccess extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin_access';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id'], 'integer'],
            [['access_name'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 255],
            [['access_name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '权限ID',
            'access_name' => '权限名字',
            'description' => '描述',
            'parent_id' => '父ID',
        ];
    }

    /**
     * @inheritdoc
     * @return AdminAccessQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AdminAccessQuery(get_called_class());
    }

    /**
     * 获取父级权限名称
     * @return string
     */
    public function getParentName(){
        if($this->parent_id == 0)
            return '顶级';
        $parent = self::findOne($this->parent_id);
        return $parent ? $parent->description : '未知';
    }
}
