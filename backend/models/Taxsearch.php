<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Tax;

/**
 * Taxsearch represents the model behind the search form about `backend\models\Tax`.
 */
class Taxsearch extends Tax
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'countryid'], 'integer'],
            [['countryname', 'taxname', 'percentage'], 'safe'],
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
        $query = Tax::find();

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
            'countryid' => $this->countryid,
        ]);

        $query->andFilterWhere(['like', 'countryname', $this->countryname])
            ->andFilterWhere(['like', 'taxname', $this->taxname])
            ->andFilterWhere(['like', 'percentage', $this->percentage]);

        return $dataProvider;
    }
}
