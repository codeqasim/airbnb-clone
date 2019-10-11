<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Claim;

/**
 * Claimsearch represents the model behind the search form about `backend\models\Claim`.
 */
class Claimsearch extends Claim
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['reservationid'], 'integer'],
            [['id','claimby', 'claimstatus', 'receiverstatus','sdamount','userid'], 'safe'],
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
    
    public function searchclaimed($params)
    {
        $claimdate = strtotime("-2 days");
        $query = Claim::find()->where(['sdstatus'=>'pending','involveadmin'=>'0'])
                              ->andWhere(['not in','receiverstatus',['accepted','declined']])
                              ->andWhere(['>=','cdate',$claimdate])
                              ->orderBy('id desc');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $query->joinWith('user');
        $query->joinWith('invoices');
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'reservationid' => $this->reservationid,
        ]);

        $query->andFilterWhere(['like', 'claimby', $this->claimby])
            ->andFilterWhere(['like', 'claimstatus', $this->claimstatus])
            ->andFilterWhere(['like', 'sdamount', $this->sdamount])
            ->andFilterWhere(['like', 'user.firstname', $this->userid])
            ->andFilterWhere(['like', 'receiverstatus', $this->receiverstatus]);

        return $dataProvider;
    }
    
    public function searchnonresponded($params)
    {
        $claimdate = strtotime("-2 days");
        $query = Claim::find()->where(['sdstatus'=>'pending','involveadmin'=>'0'])
                              ->andWhere(['not in','receiverstatus',['accepted','declined']])
                              ->andWhere(['<=','cdate',$claimdate])
                              ->orderBy('id desc');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $query->joinWith('user');
        $query->joinWith('invoices');
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'reservationid' => $this->reservationid,
        ]);

        $query->andFilterWhere(['like', 'claimby', $this->claimby])
            ->andFilterWhere(['like', 'claimstatus', $this->claimstatus])
            ->andFilterWhere(['like', 'sdamount', $this->sdamount])
            ->andFilterWhere(['like', 'user.firstname', $this->userid])
            ->andFilterWhere(['like', 'receiverstatus', $this->receiverstatus]);

        return $dataProvider;
    }    

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchguest($params)
    {
        $query = Claim::find()->where(['claimby'=>'Guest','claimstatus'=>'initiated','receiverstatus'=>'accepted','sdstatus'=>'pending'])->orderBy('id desc');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $query->joinWith('user');
        $query->joinWith('invoices');
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'reservationid' => $this->reservationid,
        ]);

        $query->andFilterWhere(['like', 'claimby', $this->claimby])
            ->andFilterWhere(['like', 'claimstatus', $this->claimstatus])
            ->andFilterWhere(['like', 'sdamount', $this->sdamount])
            ->andFilterWhere(['like', 'receiverstatus', $this->receiverstatus])
            ->andFilterWhere(['like', 'user.firstname', $this->userid]);

        return $dataProvider;
    }
    
    public function searchhost($params)
    {
        $query = Claim::find()->where(['claimby'=>'Host','claimstatus'=>'initiated','receiverstatus'=>'accepted','sdstatus'=>'pending'])->orderBy('id desc');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $query->joinWith('user');
        $query->joinWith('invoices');
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'reservationid' => $this->reservationid,
        ]);

        $query->andFilterWhere(['like', 'claimby', $this->claimby])
            ->andFilterWhere(['like', 'claimstatus', $this->claimstatus])
            ->andFilterWhere(['like', 'sdamount', $this->sdamount])
            ->andFilterWhere(['like', 'receiverstatus', $this->receiverstatus])
            ->andFilterWhere(['like', 'user.firstname', $this->userid]);

        return $dataProvider;
    }
    
    public function searchguesthost($params)
    {
        $query = Claim::find()->where(['claimstatus'=>'initiated','receiverstatus'=>'declined','sdstatus'=>'pending'])->orderBy('id desc');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $query->joinWith('user');
        $query->joinWith('invoices');
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'userid' => $this->userid,
            'reservationid' => $this->reservationid,
        ]);

        $query->andFilterWhere(['like', 'claimby', $this->claimby])
            ->andFilterWhere(['like', 'claimstatus', $this->claimstatus])
            ->andFilterWhere(['like', 'sdamount', $this->sdamount])
            ->andFilterWhere(['like', 'receiverstatus', $this->receiverstatus]);

        return $dataProvider;
    }    
}
