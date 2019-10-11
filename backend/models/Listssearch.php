<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Lists;

/**
 * Listssearch represents the model behind the search form about `backend\models\Lists`.
 */
class Listssearch extends Lists
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'createdby', 'cdate'], 'integer'],
            [['listname'], 'safe'],
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
        $query = Lists::find()->where(['user_create'=>'0']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'createdby' => $this->createdby,
            'cdate' => $this->cdate,
        ]);

        $query->andFilterWhere(['like', 'listname', $this->listname]);

        return $dataProvider;
    }
}
