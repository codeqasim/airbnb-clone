<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Invoices;

/**
 * Invoicessearch represents the model behind the search form about `backend\models\Invoices`.
 */
class Invoicessearch extends Invoices
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'orderid', 'invoicedate'], 'integer'],
            [['invoiceno', 'invoicestatus', 'paymentmethod', 'paypaltransactionid'], 'safe'],
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
        $query = Invoices::find()->orderBy('id desc');

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
            'orderid' => $this->orderid,
            'invoicedate' => $this->invoicedate,
        ]);

        $query->andFilterWhere(['like', 'invoiceno', $this->invoiceno])
            ->andFilterWhere(['like', 'invoicestatus', $this->invoicestatus])
            ->andFilterWhere(['like', 'paymentmethod', $this->paymentmethod])
            ->andFilterWhere(['like', 'paypaltransactionid', $this->paypaltransactionid]);

        return $dataProvider;
    }
}
