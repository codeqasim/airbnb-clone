<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Userreports;

/**
 * Hometypesearch represents the model behind the search form about `backend\models\Hometype`.
 */
class Listreportsearch extends Userreports
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
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
        //$query = Userreports::find()->where(['status'=>'1', 'report_type'=>'list']);
        $query = Userreports::find()
                ->where(['status'=>'1', 'report_type'=>'list'])
                ->groupBy(['listid','reportid'])
                ->having(['>','count(*)', 0])
                ->orderBy(['id'=> SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        //echo '<pre>'; print_r($dataProvider); exit;
        /*
        $query->andFilterWhere([
            'id' => $this->id,
        ]);
        */

        //$query->andFilterWhere(['like', 'reportid', $this->reportid]);

        return $dataProvider;
    }
}
