<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Admin]].
 *
 * @see Admin
 */
class AdminQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Admin[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Admin|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * 利用用户名查找有效的后台用户
     * @param string $username  用户名
     * @return $this
     */
    public function validAdminByUsername($username){
        $this->select(['id','username','password','salt','token','role_id']);
        $this->where('username=:username',[':username'=>$username]);
        $this->andWhere('is_lock=0');
        return $this;
    }

    /**
     * 利用Token查找有效的后台用户
     * @param string $token 令牌
     * @return $this
     */
    public function validAdminByToken($token){
        $this->select(['id','username','password','salt','token','role_id']);
        $this->where('token=:token',[':token'=>$token]);
        $this->andWhere('is_lock=0');
        return $this;
    }
}
