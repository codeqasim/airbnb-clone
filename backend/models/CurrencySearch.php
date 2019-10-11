<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Currency;

/**
 * CurrencySearch represents the model behind the search form about `backend\models\Currency`.
 */
class CurrencySearch extends Currency
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'cdate'], 'integer'],
            [['countrycode', 'currencycode', 'currencysymbol', 'countryname', 'currencyname', 'price', 'status'], 'safe'],
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
        $query = Currency::find();

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
            'cdate' => $this->cdate,
        ]);

        $query->andFilterWhere(['like', 'countrycode', $this->countrycode])
            ->andFilterWhere(['like', 'currencycode', $this->currencycode])
            ->andFilterWhere(['like', 'currencysymbol', $this->currencysymbol])
            ->andFilterWhere(['like', 'countryname', $this->countryname])
            ->andFilterWhere(['like', 'currencyname', $this->currencyname])
            ->andFilterWhere(['like', 'price', $this->price])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
