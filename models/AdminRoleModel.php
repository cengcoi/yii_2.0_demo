<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AdminRole;

/**
 * AdminRoleModel represents the model behind the search form about `app\models\AdminRole`.
 */
class AdminRoleModel extends AdminRole
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['role_name', 'access'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = AdminRole::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'role_name', $this->role_name])
            ->andFilterWhere(['like', 'access', $this->access]);

        return $dataProvider;
    }

    /**
     * 角色权限数组（管理员不需要进行权限赋予）
     * @param int $role_id  角色ID
     * @return array
     */
    public static function roleAccess($role_id){
        if(!$role_access = Yii::$app->filecache->get('role_access')){
            $role = self::find()->all();//把所有角色的数据做成一个数组，按照角色ID区分读取
            $role_access = [];
            if($role){
                foreach($role as $v){
                    $role_access[$v->id] = array(
                        'role_id'=>$v->id,
                        'role_name'=>$v->role_name,
                        'access'=>$v->access,
                    );
                }
            }
            Yii::$app->filecache->set('role_access',$role_access,183*24*3600);//缓存半年时间，可以手动清除
            return isset($role_access[$role_id]) && $role_access[$role_id] ? $role_access[$role_id] : array();
        }else{
            return isset($role_access[$role_id]) && $role_access[$role_id] ? $role_access[$role_id] : array();
        }
    }

    public static function roles(){
        return self::find()->asArray()->all();
    }

    /**
     * 角色构建dropDownList组件的数组
     * @return array
     */
    public static function roleSelect(){
        $data = self::find()->asArray()->all();
        $arr = [];
        if($data){
            foreach($data as $v){
                $arr[$v['id']] = $v['role_name'];
            }
        }
        return $arr;
    }
}
