<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[AdminRole]].
 *
 * @see AdminRole
 */
class AdminRoleQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return AdminRole[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return AdminRole|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
