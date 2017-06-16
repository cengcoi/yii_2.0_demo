<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AdminAccess;

/**
 * AdminAccessModel represents the model behind the search form about `app\models\AdminAccess`.
 */
class AdminAccessModel extends AdminAccess
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'parent_id'], 'integer'],
            [['access_name', 'description'], 'safe'],
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
        $query = AdminAccess::find();

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
            'parent_id' => $this->parent_id,
        ]);

        $query->andFilterWhere(['like', 'access_name', $this->access_name])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }

    /**
     * 通过ID数组获取权限名字数组
     * @param array $ids    权限ID数组
     * @return array
     */
    public static function idsAccess($ids){
        $arr = is_array($ids) ? $ids : [$ids];
        $data = self::find()->select(['access_name'])->where(['id'=>$arr])->asArray()->all();
        $return = [];
        if($data){
            foreach($data as $v)
                $return[] = $v['access_name'];
        }
        return $return;
    }

    /**
     * 父级权限项
     * @param array $ignore 忽略权限ID数组
     * @return array
     */
    public function parentAccess($ignore=[]){
        $ignore_arr = is_array($ignore) ? $ignore : [$ignore];

        $data = self::find()->parentAccess($ignore_arr)->all();

        $return = array(0=>'顶级');
        foreach($data as $v){
            $return[$v['id']] = $v['description'];
        }
        return $return;
    }

    public function accessTree(){
        $data = self::find()->all();
        return $this->tree($data);
    }

    public function tree($data,$parent_id=0,$layer=0){
        $children = $this->findChildren($data,$parent_id,$layer);

        foreach($children as $k=>$v){
            $sons = $this->tree($data,$v['id'],$layer+1);
            if(!empty($sons))
                $children[$k]['children'] = $sons;
        }
        return $children;
    }

    protected function findChildren($data,$parent_id=0,$layer=0,$str='&nbsp;&nbsp;&nbsp;&nbsp;'){
        $children = array();
        foreach($data as $k=>$v){
            if($v['parent_id'] == $parent_id)
                $children[] = array(
                    'id'=>$v['id'],
                    'description'=>str_repeat($str,$layer).$v['description'],
                    'parent_id'=>$v['parent_id'],
                );
        }
        return $children;
    }
}
