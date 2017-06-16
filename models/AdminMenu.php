<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "admin_menu".
 *
 * @property string $id
 * @property string $menu_text
 * @property string $icon_alias
 * @property string $url
 * @property string $access_name
 * @property string $parent_id
 * @property integer $is_display
 * @property integer $rank
 * @property integer $is_sys
 */
class AdminMenu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin_menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['menu_text','url','access_name','rank'],'required'],
            [['parent_id', 'is_display', 'rank', 'is_sys'], 'integer'],
            [['menu_text'], 'string', 'max' => 200],
            [['icon_alias', 'url', 'access_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '菜单ID',
            'menu_text' => '菜单文字',
            'icon_alias' => '图标别名',//使用fontawesomeicon中fa后面带的别名，不需要中横杠
            'url' => '路径',//基本上是yii中生成路径带的参数。
            'access_name' => 'url别名',//由controller或者加action组成
            'parent_id' => '父ID',
            'is_display' => '是否显示',
            'rank' => '排序',//越大排越前
            'is_sys' => '系统菜单',
        ];
    }

    /**
     * @inheritdoc
     * @return AdminMenuQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AdminMenuQuery(get_called_class());
    }

    /**
     * 父级名字
     * @return string
     */
    public function getParentName(){
        if($this->parent_id == 0)
            return '顶级';
        $parent = self::findOne($this->parent_id);
        return $parent ? $parent->menu_text : '未知父级';
    }
}
