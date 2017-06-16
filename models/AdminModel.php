<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Admin;

/**
 * AdminModel represents the model behind the search form about `app\models\Admin`.
 */
class AdminModel extends Admin
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'role_id', 'is_lock'], 'integer'],
            [['username', 'password', 'salt', 'token'], 'safe'],
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
        $query = Admin::find();

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
            'role_id' => $this->role_id,
            'is_lock' => $this->is_lock,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'salt', $this->salt])
            ->andFilterWhere(['like', 'token', $this->token]);

        return $dataProvider;
    }
}
