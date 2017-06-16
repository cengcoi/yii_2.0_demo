<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AdminMenu;

/**
 * AdminMenuModel represents the model behind the search form about `app\models\AdminMenu`.
 */
class AdminMenuModel extends AdminMenu
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'parent_id', 'is_display', 'rank', 'is_sys'], 'integer'],
            [['menu_text', 'icon_alias', 'url', 'access_name'], 'safe'],
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
        $query = AdminMenu::find();

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
            'is_display' => $this->is_display,
            'rank' => $this->rank,
            'is_sys' => $this->is_sys,
        ]);

        $query->andFilterWhere(['like', 'menu_text', $this->menu_text])
            ->andFilterWhere(['like', 'icon_alias', $this->icon_alias])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'access_name', $this->access_name]);

        return $dataProvider;
    }

    /**
     * 所有菜单数据
     * @return array
     */
    public function menu(){
        $data = self::find()->select(['id','menu_text','icon_alias','url','access_name','parent_id'])
            ->where(['is_display'=>1])->orderBy(['rank'=>SORT_DESC])->asArray()->all();
        return $this->tree($data,0);
    }

    private function tree($data,$parent_id=0){
        $children = $this->children($data,$parent_id);
        if(empty($children))
            return [];

        foreach($children as $k=>$v){
            $child = $this->tree($data,$v['id']);
            if(!empty($child))
                $children[$k]['child'] = $child;
        }
        return $children;
    }
    private function children($data,$parent_id=0){
        $children = [];
        if($data){
            foreach($data as $k=>$v){
                if($v['parent_id'] == $parent_id){
                    $children[] = $v;
                }
            }
        }
        return $children;
    }
    /**
     * 个人菜单
     * @return array
     */
    public function person_menu(){
        $role_id = Yii::$app->admin->identity->role_id;
        if($role_id == 1)
            return $this->menu();
        else{
            $role_access = AdminRoleModel::roleAccess($role_id);
            if(!isset($role_access['access']) || !$role_access['access'])
                return array();
            $allowAccessArr = AdminAccessModel::idsAccess(explode(',',$role_access['access']));

            $data = self::find()->select(['id','menu_text','icon_alias','url','access_name','parent_id'])
                ->where(['access_name'=>$allowAccessArr])
                ->andWhere('is_display=1')
                ->orderBy(['rank'=>SORT_DESC])
                ->asArray()
                ->all();
            return $this->tree($data);
        }
    }

    /**
     * 目前左侧菜单最多两层，因为父层只拿顶级0和第一级的各个项
     * @param array $ignore
     * @return array
     */
    public static function parentMenu($ignore=[]){
        $ignore_arr = is_array($ignore) ? $ignore : array($ignore);

        $data = self::find()->parentMenu($ignore_arr)
            ->asArray()
            ->all();
        $menu = array(0=>'顶级');
        if($data){
            foreach($data as $v){
                $menu[$v['id']] = $v['menu_text'];
            }
        }

        return $menu;
    }
}
