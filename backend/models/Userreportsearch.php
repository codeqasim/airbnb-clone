<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Userreports;
use backend\models\Cancellation;

/**
 * Hometypesearch represents the model behind the search form about `backend\models\Hometype`.
 */
class Userreportsearch extends Userreports
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
        $query = Userreports::find()
                ->where(['status'=>'1', 'report_type'=>'profile'])
                ->groupBy(['reporterid','reportid'])
                ->having(['>','count(*)', 0])
                ->orderBy(['id'=> SORT_DESC]);
                /* ->all(); */

        /* 
            echo 'Get all datas';
            echo '<pre>'; print_r($query); exit;
            select reporterid from hts_userreports group by reporterid having count(*) >0 ORDER BY id ASC
        */

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id' => SORT_DESC]]
        ]);

        $this->load($params);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        return $dataProvider;
    }
}
