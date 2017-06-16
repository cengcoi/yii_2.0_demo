<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[AdminAccess]].
 *
 * @see AdminAccess
 */
class AdminAccessQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return AdminAccess[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return AdminAccess|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * 父级权限项
     * @param $ignore
     * @return $this
     */
    public function parentAccess($ignore){
        $this->select(['id','description']);
        $this->where('parent_id=0');
        if($ignore)
            $this->andFilterWhere(['not in','id',$ignore]);
        $this->orderBy(['id'=>SORT_DESC]);
        return $this;
    }
}
