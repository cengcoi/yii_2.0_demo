<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[AdminMenu]].
 *
 * @see AdminMenu
 */
class AdminMenuQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return AdminMenu[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return AdminMenu|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     *
     * @param $ignore
     * @return $this
     */
    public function parentMenu($ignore){
        $this->select(['id','menu_text']);
        $this->where('parent_id=0');
        $this->andWhere('is_display=1');
        if($ignore)
            $this->andFilterWhere(['not in','id',$ignore]);
        return $this;
    }
}
