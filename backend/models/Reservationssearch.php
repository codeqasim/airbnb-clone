<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Reservations;
use backend\models\Claim;

/**
 * Reservationssearch represents the model behind the search form about `backend\models\Reservations`.
 */
class Reservationssearch extends Reservations
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fromdate', 'todate', 'guests', 'totaldays'], 'integer'],
            [['pricepernight', 'id','listid','userid','hostid','currencycode','commissionfees', 'servicefees', 'taxfees', 'securityfees', 'total', 'booktype', 'bookstatus', 'cancelby', 'orderstatus', 'cdate'], 'safe'],
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
        $query = Reservations::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
       
        $query->joinWith('user');
        $query->joinWith('host');
         $query->joinWith('list');
        $query->joinWith('invoices');
        //$query->joinWith('host');
        
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'fromdate' => $this->fromdate,
            'todate' => $this->todate,
            'guests' => $this->guests,
            'totaldays' => $this->totaldays,
            'cdate' => $this->cdate,
            'bookstatus' => 'accepted',
            'orderstatus' => 'pending'
        ]);

        $query->andFilterWhere(['like', 'pricepernight', $this->pricepernight])
            ->andFilterWhere(['like', 'ADD(commissionfees, servicefees)', $this->commissionfees])
            ->andFilterWhere(['like', 'servicefees', $this->servicefees])
            ->andFilterWhere(['like', 'taxfees', $this->taxfees])
            ->andFilterWhere(['like', 'securityfees', $this->securityfees])
            ->andFilterWhere(['like', 'total', $this->total])
            ->andFilterWhere(['like', 'booktype', $this->booktype])
            ->andFilterWhere(['like', 'currencycode', $this->currencycode])
            ->andFilterWhere(['like', 'bookstatus', $this->bookstatus])
            ->andFilterWhere(['like', 'cancelby', $this->cancelby])
            ->andFilterWhere(['like', 'hts_listing.listingname', $this->listid])
            ->andFilterWhere(['like', 'hts_invoices.paypaltransactionid', $this->id])
            ->andFilterWhere(['like', 'host.firstname', $this->hostid])
            ->andFilterWhere(['like', 'user.firstname', $this->userid])
            
            ->andFilterWhere(['like', 'orderstatus', $this->orderstatus]);

        return $dataProvider;
    }
    
    public function searchcancelled($params)
    {
        $query = Reservations::find()->orderBy('id desc');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $query->joinWith('user');
        $query->joinWith('host');
         $query->joinWith('list');
        $query->joinWith('invoices');
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'fromdate' => $this->fromdate,
            'todate' => $this->todate,
            'guests' => $this->guests,
            'totaldays' => $this->totaldays,
            'cdate' => $this->cdate,
            'bookstatus' => 'cancelled',
            'orderstatus' => 'pending'
        ]);

        $query->andFilterWhere(['like', 'pricepernight', $this->pricepernight])
            ->andFilterWhere(['like', 'ADD(commissionfees, servicefees)', $this->commissionfees])
            ->andFilterWhere(['like', 'servicefees', $this->servicefees])
            ->andFilterWhere(['like', 'taxfees', $this->taxfees])
            ->andFilterWhere(['like', 'securityfees', $this->securityfees])
            ->andFilterWhere(['like', 'total', $this->total])
            ->andFilterWhere(['like', 'booktype', $this->booktype])
            ->andFilterWhere(['like', 'currencycode', $this->currencycode])
            ->andFilterWhere(['like', 'bookstatus', $this->bookstatus])
            ->andFilterWhere(['like', 'cancelby', $this->cancelby])
            ->andFilterWhere(['like', 'hts_listing.listingname', $this->listid])
            ->andFilterWhere(['like', 'hts_invoices.paypaltransactionid', $this->id])
            ->andFilterWhere(['like', 'host.firstname', $this->hostid])
            ->andFilterWhere(['like', 'user.firstname', $this->userid])
            
            ->andFilterWhere(['like', 'orderstatus', $this->orderstatus]);

        return $dataProvider;
    }
    
    public function searchdeclined($params)
    {
        $query = Reservations::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $query->joinWith('user');
        $query->joinWith('host');
         $query->joinWith('list');
        $query->joinWith('invoices');
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'fromdate' => $this->fromdate,
            'todate' => $this->todate,
            'guests' => $this->guests,
            'totaldays' => $this->totaldays,
            'cdate' => $this->cdate,
            'bookstatus' => 'declined',
            'orderstatus' => 'pending'
        ]);

        $query->andFilterWhere(['like', 'pricepernight', $this->pricepernight])
            ->andFilterWhere(['like', 'ADD(commissionfees, servicefees)', $this->commissionfees])
            ->andFilterWhere(['like', 'servicefees', $this->servicefees])
            ->andFilterWhere(['like', 'taxfees', $this->taxfees])
            ->andFilterWhere(['like', 'securityfees', $this->securityfees])
            ->andFilterWhere(['like', 'total', $this->total])
            ->andFilterWhere(['like', 'booktype', $this->booktype])
            ->andFilterWhere(['like', 'currencycode', $this->currencycode])
            ->andFilterWhere(['like', 'bookstatus', $this->bookstatus])
            ->andFilterWhere(['like', 'cancelby', $this->cancelby])
            ->andFilterWhere(['like', 'hts_listing.listingname', $this->listid])
            ->andFilterWhere(['like', 'hts_invoices.paypaltransactionid', $this->id])
            ->andFilterWhere(['like', 'host.firstname', $this->hostid])
            ->andFilterWhere(['like', 'user.firstname', $this->userid])
            
            ->andFilterWhere(['like', 'orderstatus', $this->orderstatus]);

        return $dataProvider;
    }
    
    public function searchnonclaimed($params)
    {
        $claimdata = Claim::find('all')->all();
        if(isset($claimdata) && !empty($claimdata))
        {
        foreach($claimdata as $claim)
        {
            $claimids[] = $claim->reservationid;
        }
        $query = Reservations::find()->where(['not in','hts_reservations.id',$claimids]);
        $query->joinWith('invoices');
        $query->joinWith('user');
        $query->joinWith('host');
        

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
            'fromdate' => $this->fromdate,
            'todate' => $this->todate,
            'guests' => $this->guests,
            'totaldays' => $this->totaldays,
            'cdate' => $this->cdate,
            'bookstatus' => 'accepted',
            'orderstatus' => 'pending',
            'sdstatus' => 'pending'
        ]);

        $query->andFilterWhere(['like', 'pricepernight', $this->pricepernight])
        ->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'servicefees', $this->servicefees])
            ->andFilterWhere(['like', 'taxfees', $this->taxfees])
            ->andFilterWhere(['like', 'securityfees', $this->securityfees])
            ->andFilterWhere(['like', 'total', $this->total])
            ->andFilterWhere(['like', 'booktype', $this->booktype])
            ->andFilterWhere(['like', 'currencycode', $this->currencycode])
            ->andFilterWhere(['like', 'bookstatus', $this->bookstatus])
            ->andFilterWhere(['like', 'cancelby', $this->cancelby])
            ->andFilterWhere(['like', 'hts_listing.listingname', $this->listid])
            ->andFilterWhere(['like', 'hts_invoices.paypaltransactionid', $this->id])
            ->andFilterWhere(['like', 'host.firstname', $this->hostid])
            ->andFilterWhere(['like', 'user.firstname', $this->userid])
            
            ->andFilterWhere(['like', 'orderstatus', $this->orderstatus]);
            return $dataProvider;
        }

        
    }
    
    public function searchpending($params)
    {
        $query = Reservations::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $query->joinWith('user');
        $query->joinWith('host');
         $query->joinWith('list');
        $query->joinWith('invoices');
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'fromdate' => $this->fromdate,
            'todate' => $this->todate,
            'guests' => $this->guests,
            'totaldays' => $this->totaldays,
            'cdate' => $this->cdate,
            'bookstatus' => 'requested',
            'orderstatus' => 'pending'
        ]);

        $query->andFilterWhere(['like', 'pricepernight', $this->pricepernight])
            ->andFilterWhere(['like', 'ADD(commissionfees, servicefees)', $this->commissionfees])
            ->andFilterWhere(['like', 'servicefees', $this->servicefees])
            ->andFilterWhere(['like', 'taxfees', $this->taxfees])
            ->andFilterWhere(['like', 'securityfees', $this->securityfees])
            ->andFilterWhere(['like', 'total', $this->total])
            ->andFilterWhere(['like', 'booktype', $this->booktype])
            ->andFilterWhere(['like', 'currencycode', $this->currencycode])
            ->andFilterWhere(['like', 'bookstatus', $this->bookstatus])
            ->andFilterWhere(['like', 'cancelby', $this->cancelby])
            ->andFilterWhere(['like', 'hts_listing.listingname', $this->listid])
            ->andFilterWhere(['like', 'hts_invoices.paypaltransactionid', $this->id])
            ->andFilterWhere(['like', 'host.firstname', $this->hostid])
            ->andFilterWhere(['like', 'user.firstname', $this->userid])
            
            ->andFilterWhere(['like', 'orderstatus', $this->orderstatus]);

        return $dataProvider;
    }
    
    public function searchpaid($params)
    {
        $query = Reservations::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $query->joinWith('user');
        $query->joinWith('host');
         $query->joinWith('list');
        $query->joinWith('invoices');
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->andWhere(['in','bookstatus',['accepted','cancelled','declined']]);
        $query->andFilterWhere([
            'fromdate' => $this->fromdate,
            'todate' => $this->todate,
            'guests' => $this->guests,
            'totaldays' => $this->totaldays,
            'cdate' => $this->cdate,
            'orderstatus' => 'paid'
        ]);

        $query->andFilterWhere(['like', 'pricepernight', $this->pricepernight])
            ->andFilterWhere(['like', 'ADD(commissionfees, servicefees)', $this->commissionfees])
            ->andFilterWhere(['like', 'servicefees', $this->servicefees])
            ->andFilterWhere(['like', 'taxfees', $this->taxfees])
            ->andFilterWhere(['like', 'securityfees', $this->securityfees])
            ->andFilterWhere(['like', 'total', $this->total])
            ->andFilterWhere(['like', 'booktype', $this->booktype])
            ->andFilterWhere(['like', 'currencycode', $this->currencycode])
            ->andFilterWhere(['like', 'bookstatus', $this->bookstatus])
            ->andFilterWhere(['like', 'cancelby', $this->cancelby])
            ->andFilterWhere(['like', 'hts_listing.listingname', $this->listid])
            ->andFilterWhere(['like', 'hts_invoices.paypaltransactionid', $this->id])
            ->andFilterWhere(['like', 'host.firstname', $this->hostid])
            ->andFilterWhere(['like', 'user.firstname', $this->userid])
            
            ->andFilterWhere(['like', 'orderstatus', $this->orderstatus]);

        return $dataProvider;
    }

     public function searchincompletereservations($params)
    {
        $query = Reservations::find()->orderBy('id desc');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $query->joinWith('user');
        $query->joinWith('host');
         $query->joinWith('list');
        $query->joinWith('invoices');
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->andWhere(['in','bookstatus',['accepted','cancelled','declined','requested']]);
        $query->andFilterWhere([
            'fromdate' => $this->fromdate,
            'todate' => $this->todate,
            'guests' => $this->guests,
            'totaldays' => $this->totaldays,
            'cdate' => $this->cdate,
            'orderstatus' => 'pending'
        ]);

        $query->andFilterWhere(['like', 'pricepernight', $this->pricepernight])
            ->andFilterWhere(['like', 'ADD(commissionfees, servicefees)', $this->commissionfees])
            ->andFilterWhere(['like', 'servicefees', $this->servicefees])
            ->andFilterWhere(['like', 'taxfees', $this->taxfees])
            ->andFilterWhere(['like', 'securityfees', $this->securityfees])
            ->andFilterWhere(['like', 'total', $this->total])
            ->andFilterWhere(['like', 'booktype', $this->booktype])
            ->andFilterWhere(['like', 'currencycode', $this->currencycode])
            ->andFilterWhere(['like', 'bookstatus', $this->bookstatus])
            ->andFilterWhere(['like', 'cancelby', $this->cancelby])
            ->andFilterWhere(['like', 'hts_listing.listingname', $this->listid])
            ->andFilterWhere(['like', 'hts_invoices.paypaltransactionid', $this->id])
            ->andFilterWhere(['like', 'host.firstname', $this->hostid])
            ->andFilterWhere(['like', 'user.firstname', $this->userid])
            
            ->andFilterWhere(['like', 'orderstatus', $this->orderstatus]);

        return $dataProvider;
    }

    public function searchcompletereservations($params)
    {
        $query = Reservations::find()->orderBy('id desc'); 

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $query->joinWith('user');
        $query->joinWith('host');
         $query->joinWith('list');
        $query->joinWith('invoices');
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->andWhere(['in','bookstatus',['accepted','refunded','declined']]);
        $query->andFilterWhere([
            'fromdate' => $this->fromdate,
            'todate' => $this->todate,
            'guests' => $this->guests,
            'totaldays' => $this->totaldays,
            'cdate' => $this->cdate,
            'orderstatus' => 'paid'
        ]);
 
        $query->andFilterWhere(['like', 'pricepernight', $this->pricepernight])
            ->andFilterWhere(['like', 'ADD(commissionfees, servicefees)', $this->commissionfees])
            ->andFilterWhere(['like', 'servicefees', $this->servicefees])
            ->andFilterWhere(['like', 'taxfees', $this->taxfees])
            ->andFilterWhere(['like', 'securityfees', $this->securityfees])
            ->andFilterWhere(['like', 'total', $this->total])
            ->andFilterWhere(['like', 'booktype', $this->booktype])
            ->andFilterWhere(['like', 'currencycode', $this->currencycode])
            ->andFilterWhere(['like', 'bookstatus', $this->bookstatus])
            ->andFilterWhere(['like', 'cancelby', $this->cancelby])
            ->andFilterWhere(['like', 'hts_listing.listingname', $this->listid])
            ->andFilterWhere(['like', 'hts_invoices.paypaltransactionid', $this->id])
            ->andFilterWhere(['like', 'host.firstname', $this->hostid])
            ->andFilterWhere(['like', 'user.firstname', $this->userid])
            
            ->andFilterWhere(['like', 'orderstatus', $this->orderstatus]);

        return $dataProvider;
    }

    public function searchcompleteclaim($params)
    {
        $query = Reservations::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $query->joinWith('user');
        $query->joinWith('host');
         $query->joinWith('list');
        $query->joinWith('invoices');
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->andWhere(['in','bookstatus',['claimed']]);
        $query->andFilterWhere([
            'fromdate' => $this->fromdate,
            'todate' => $this->todate,
            'guests' => $this->guests,
            'totaldays' => $this->totaldays,
            'cdate' => $this->cdate,
            'sdstatus' => 'paid',
            'orderstatus' => 'paid'
        ]);

        $query->andFilterWhere(['like', 'pricepernight', $this->pricepernight])
            ->andFilterWhere(['like', 'ADD(commissionfees, servicefees)', $this->commissionfees])
            ->andFilterWhere(['like', 'servicefees', $this->servicefees])
            ->andFilterWhere(['like', 'taxfees', $this->taxfees])
            ->andFilterWhere(['like', 'securityfees', $this->securityfees])
            ->andFilterWhere(['like', 'total', $this->total])
            ->andFilterWhere(['like', 'booktype', $this->booktype])
            ->andFilterWhere(['like', 'currencycode', $this->currencycode])
            ->andFilterWhere(['like', 'bookstatus', $this->bookstatus])
            ->andFilterWhere(['like', 'cancelby', $this->cancelby])
            ->andFilterWhere(['like', 'hts_listing.listingname', $this->listid])
            ->andFilterWhere(['like', 'hts_invoices.paypaltransactionid', $this->id])
            ->andFilterWhere(['like', 'host.firstname', $this->hostid])
            ->andFilterWhere(['like', 'user.firstname', $this->userid])
            
            ->andFilterWhere(['like', 'orderstatus', $this->orderstatus]);

        return $dataProvider;
    }

    public function searchincompleteclaim($params)
    {
        $query = Reservations::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $query->joinWith('user');
        $query->joinWith('host');
         $query->joinWith('list');
        $query->joinWith('invoices');
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->andWhere(['in','bookstatus',['claimed']]);
        $query->andWhere(['>','securityfees',0]);
        $query->andFilterWhere([
            'fromdate' => $this->fromdate,
            'todate' => $this->todate,
            'guests' => $this->guests,
            'totaldays' => $this->totaldays,
            'cdate' => $this->cdate,
            'sdstatus' => 'pending',
            'orderstatus' => 'pending'
        ]);

        $query->andFilterWhere(['like', 'pricepernight', $this->pricepernight])
            ->andFilterWhere(['like', 'ADD(commissionfees, servicefees)', $this->commissionfees])
            ->andFilterWhere(['like', 'servicefees', $this->servicefees])
            ->andFilterWhere(['like', 'taxfees', $this->taxfees])
            ->andFilterWhere(['like', 'securityfees', $this->securityfees])
            ->andFilterWhere(['like', 'total', $this->total])
            ->andFilterWhere(['like', 'booktype', $this->booktype])
            ->andFilterWhere(['like', 'currencycode', $this->currencycode])
            ->andFilterWhere(['like', 'bookstatus', $this->bookstatus])
            ->andFilterWhere(['like', 'cancelby', $this->cancelby])
            ->andFilterWhere(['like', 'hts_listing.listingname', $this->listid])
            ->andFilterWhere(['like', 'hts_invoices.paypaltransactionid', $this->id])
            ->andFilterWhere(['like', 'host.firstname', $this->hostid])
            ->andFilterWhere(['like', 'user.firstname', $this->userid])
            
            ->andFilterWhere(['like', 'orderstatus', $this->orderstatus]);

        return $dataProvider;
    } 
   
}
