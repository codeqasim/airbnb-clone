<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Listing;

/**
 * Listingsearch represents the model behind the search form about `backend\models\Listing`.
 */
class Listingsearch extends Listing
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'userid', 'hometype', 'roomtype', 'accommodates', 'bedrooms', 'beds', 'bathrooms', 'country', 'zipcode', 'medicalno', 'fireno', 'policeno', 'currency', 'startdate', 'enddate', 'minstay', 'maxstay', 'advancenotice'], 'integer'],
            [['city', 'listingname', 'description', 'streetaddress', 'accesscode', 'state', 'commonamenities', 'additionalamenities', 'specialfeatures', 'safetychecklist', 'fireextinguisher', 'firealarm', 'gasshutoffvalve', 'emergencyexitinstruction', 'nightlyprice', 'hourlyprice', 'securitydeposit', 'bookingstyle', 'whocanbook', 'houserules', 'bookingavailability', 'priceforextrapeople', 'weeklydiscount', 'monthlydisocunt', 'cancellation', 'cdate'], 'safe'],
            [['latitude', 'longitude'], 'number'],
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
    public function search($params,$id)
    {
        $query = Listing::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->andWhere(['in','liststatus',['0','1','2']]);
        $query->andFilterWhere([
            'id' => $this->id,
            'userid' => $id,
            'hometype' => $this->hometype,
            'roomtype' => $this->roomtype,
            'accommodates' => $this->accommodates,
            'bedrooms' => $this->bedrooms,
            'beds' => $this->beds,
            'bathrooms' => $this->bathrooms,
            'country' => $this->country,
            'zipcode' => $this->zipcode,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'medicalno' => $this->medicalno,
            'fireno' => $this->fireno,
            'policeno' => $this->policeno,
            'currency' => $this->currency,
            'startdate' => $this->startdate,
            'enddate' => $this->enddate,
            'minstay' => $this->minstay,
            'maxstay' => $this->maxstay,
            'advancenotice' => $this->advancenotice,
        ]);

        $query->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'listingname', $this->listingname])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'streetaddress', $this->streetaddress])
            ->andFilterWhere(['like', 'accesscode', $this->accesscode])
            ->andFilterWhere(['like', 'state', $this->state])
            ->andFilterWhere(['like', 'commonamenities', $this->commonamenities])
            ->andFilterWhere(['like', 'additionalamenities', $this->additionalamenities])
            ->andFilterWhere(['like', 'specialfeatures', $this->specialfeatures])
            ->andFilterWhere(['like', 'safetychecklist', $this->safetychecklist])
            ->andFilterWhere(['like', 'fireextinguisher', $this->fireextinguisher])
            ->andFilterWhere(['like', 'firealarm', $this->firealarm])
            ->andFilterWhere(['like', 'gasshutoffvalve', $this->gasshutoffvalve])
            ->andFilterWhere(['like', 'emergencyexitinstruction', $this->emergencyexitinstruction])
            ->andFilterWhere(['like', 'nightlyprice', $this->nightlyprice])
            ->andFilterWhere(['like', 'hourlyprice', $this->hourlyprice]) 
            ->andFilterWhere(['like', 'securitydeposit', $this->securitydeposit])
            ->andFilterWhere(['like', 'bookingstyle', $this->bookingstyle])
            ->andFilterWhere(['like', 'whocanbook', $this->whocanbook])
            ->andFilterWhere(['like', 'houserules', $this->houserules])
            ->andFilterWhere(['like', 'bookingavailability', $this->bookingavailability])
            ->andFilterWhere(['like', 'priceforextrapeople', $this->priceforextrapeople])
            ->andFilterWhere(['like', 'weeklydiscount', $this->weeklydiscount])
            ->andFilterWhere(['like', 'monthlydisocunt', $this->monthlydisocunt])
            ->andFilterWhere(['like', 'cancellation', $this->cancellation])
            ->andFilterWhere(['like', 'cdate', $this->cdate]);

        return $dataProvider;
    }

    public function activelisting($params,$id)
    {
        $query = Listing::find();

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
        $query->andWhere(['=','userid',$id]); 
        $query->andWhere(['=','liststatus','1']); 
        $query->andFilterWhere([
            'id' => $this->id,
            'hometype' => $this->hometype,
            'roomtype' => $this->roomtype,
            'accommodates' => $this->accommodates,
            'bedrooms' => $this->bedrooms,
            'beds' => $this->beds,
            'bathrooms' => $this->bathrooms,
            'country' => $this->country,
            'zipcode' => $this->zipcode,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'medicalno' => $this->medicalno,
            'fireno' => $this->fireno,
            'policeno' => $this->policeno,
            'currency' => $this->currency,
            'startdate' => $this->startdate,
            'enddate' => $this->enddate,
            'minstay' => $this->minstay,
            'maxstay' => $this->maxstay,
            'advancenotice' => $this->advancenotice,
        ]);

        $query->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'listingname', $this->listingname])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'streetaddress', $this->streetaddress])
            ->andFilterWhere(['like', 'accesscode', $this->accesscode])
            ->andFilterWhere(['like', 'state', $this->state])
            ->andFilterWhere(['like', 'commonamenities', $this->commonamenities])
            ->andFilterWhere(['like', 'additionalamenities', $this->additionalamenities])
            ->andFilterWhere(['like', 'specialfeatures', $this->specialfeatures])
            ->andFilterWhere(['like', 'safetychecklist', $this->safetychecklist])
            ->andFilterWhere(['like', 'fireextinguisher', $this->fireextinguisher])
            ->andFilterWhere(['like', 'firealarm', $this->firealarm])
            ->andFilterWhere(['like', 'gasshutoffvalve', $this->gasshutoffvalve])
            ->andFilterWhere(['like', 'emergencyexitinstruction', $this->emergencyexitinstruction])
            ->andFilterWhere(['like', 'nightlyprice', $this->nightlyprice])
            ->andFilterWhere(['like', 'securitydeposit', $this->securitydeposit])
            ->andFilterWhere(['like', 'bookingstyle', $this->bookingstyle])
            ->andFilterWhere(['like', 'whocanbook', $this->whocanbook])
            ->andFilterWhere(['like', 'houserules', $this->houserules])
            ->andFilterWhere(['like', 'bookingavailability', $this->bookingavailability])
            ->andFilterWhere(['like', 'priceforextrapeople', $this->priceforextrapeople])
            ->andFilterWhere(['like', 'weeklydiscount', $this->weeklydiscount])
            ->andFilterWhere(['like', 'monthlydisocunt', $this->monthlydisocunt])
            ->andFilterWhere(['like', 'cancellation', $this->cancellation])
            ->andFilterWhere(['like', 'cdate', $this->cdate]);

        return $dataProvider;
    }
 
    public function blockerlisting($params,$id) 
    {
        $query = Listing::find();

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
        $query->andWhere(['=','userid',$id]); 
        $query->andWhere(['=','liststatus','2']);  
        $query->andWhere(['!=','bookingavailability','NULL']);   
        $query->andFilterWhere([
            'id' => $this->id,
            'hometype' => $this->hometype,
            'roomtype' => $this->roomtype,
            'accommodates' => $this->accommodates,
            'bedrooms' => $this->bedrooms,
            'beds' => $this->beds,
            'bathrooms' => $this->bathrooms,
            'country' => $this->country,
            'zipcode' => $this->zipcode,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'medicalno' => $this->medicalno,
            'fireno' => $this->fireno,
            'policeno' => $this->policeno,
            'currency' => $this->currency,
            'startdate' => $this->startdate,
            'enddate' => $this->enddate,
            'minstay' => $this->minstay,
            'maxstay' => $this->maxstay,
            'advancenotice' => $this->advancenotice,
        ]);

        $query->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'listingname', $this->listingname])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'streetaddress', $this->streetaddress])
            ->andFilterWhere(['like', 'accesscode', $this->accesscode])
            ->andFilterWhere(['like', 'state', $this->state])
            ->andFilterWhere(['like', 'commonamenities', $this->commonamenities])
            ->andFilterWhere(['like', 'additionalamenities', $this->additionalamenities])
            ->andFilterWhere(['like', 'specialfeatures', $this->specialfeatures])
            ->andFilterWhere(['like', 'safetychecklist', $this->safetychecklist])
            ->andFilterWhere(['like', 'fireextinguisher', $this->fireextinguisher])
            ->andFilterWhere(['like', 'firealarm', $this->firealarm])
            ->andFilterWhere(['like', 'gasshutoffvalve', $this->gasshutoffvalve])
            ->andFilterWhere(['like', 'emergencyexitinstruction', $this->emergencyexitinstruction])
            ->andFilterWhere(['like', 'nightlyprice', $this->nightlyprice])
            ->andFilterWhere(['like', 'securitydeposit', $this->securitydeposit])
            ->andFilterWhere(['like', 'bookingstyle', $this->bookingstyle])
            ->andFilterWhere(['like', 'whocanbook', $this->whocanbook])
            ->andFilterWhere(['like', 'houserules', $this->houserules])
            ->andFilterWhere(['like', 'bookingavailability', $this->bookingavailability])
            ->andFilterWhere(['like', 'priceforextrapeople', $this->priceforextrapeople])
            ->andFilterWhere(['like', 'weeklydiscount', $this->weeklydiscount])
            ->andFilterWhere(['like', 'monthlydisocunt', $this->monthlydisocunt])
            ->andFilterWhere(['like', 'cancellation', $this->cancellation])
            ->andFilterWhere(['like', 'cdate', $this->cdate]);

        return $dataProvider;
    }

     public function activesearch($params,$blocked=array())
    {
        $query = Listing::find();

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
        $query->andWhere(['not in','userid',$blocked]); 
        $query->andWhere(['in','liststatus',['1']]);
        $query->andFilterWhere([
            'id' => $this->id,
            'hometype' => $this->hometype,
            'roomtype' => $this->roomtype,
            'accommodates' => $this->accommodates,
            'bedrooms' => $this->bedrooms,
            'beds' => $this->beds,
            'bathrooms' => $this->bathrooms,
            'country' => $this->country,
            'zipcode' => $this->zipcode,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'medicalno' => $this->medicalno,
            'fireno' => $this->fireno,
            'policeno' => $this->policeno,
            'currency' => $this->currency,
            'startdate' => $this->startdate,
            'enddate' => $this->enddate,
            'minstay' => $this->minstay,
            'maxstay' => $this->maxstay,
            'advancenotice' => $this->advancenotice,
        ]);

        $query->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'listingname', $this->listingname])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'streetaddress', $this->streetaddress])
            ->andFilterWhere(['like', 'accesscode', $this->accesscode])
            ->andFilterWhere(['like', 'state', $this->state])
            ->andFilterWhere(['like', 'commonamenities', $this->commonamenities])
            ->andFilterWhere(['like', 'additionalamenities', $this->additionalamenities])
            ->andFilterWhere(['like', 'specialfeatures', $this->specialfeatures])
            ->andFilterWhere(['like', 'safetychecklist', $this->safetychecklist])
            ->andFilterWhere(['like', 'fireextinguisher', $this->fireextinguisher])
            ->andFilterWhere(['like', 'firealarm', $this->firealarm])
            ->andFilterWhere(['like', 'gasshutoffvalve', $this->gasshutoffvalve])
            ->andFilterWhere(['like', 'emergencyexitinstruction', $this->emergencyexitinstruction])
            ->andFilterWhere(['like', 'nightlyprice', $this->nightlyprice])
            ->andFilterWhere(['like', 'securitydeposit', $this->securitydeposit])
            ->andFilterWhere(['like', 'bookingstyle', $this->bookingstyle])
            ->andFilterWhere(['like', 'whocanbook', $this->whocanbook])
            ->andFilterWhere(['like', 'houserules', $this->houserules])
            ->andFilterWhere(['like', 'bookingavailability', $this->bookingavailability])
            ->andFilterWhere(['like', 'priceforextrapeople', $this->priceforextrapeople])
            ->andFilterWhere(['like', 'weeklydiscount', $this->weeklydiscount])
            ->andFilterWhere(['like', 'monthlydisocunt', $this->monthlydisocunt])
            ->andFilterWhere(['like', 'cancellation', $this->cancellation])
            ->andFilterWhere(['like', 'cdate', $this->cdate]);

        return $dataProvider;
    }

     public function blocksearch($params,$blocked=array())
    {
        $query = Listing::find();

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
        //$query->andWhere(['not in','userid',$blocked]);
        $query->andWhere(['liststatus'=>'2']);
        $query->andFilterWhere([
            'id' => $this->id,
            'hometype' => $this->hometype,
            'roomtype' => $this->roomtype,
            'accommodates' => $this->accommodates,
            'bedrooms' => $this->bedrooms,
            'beds' => $this->beds,
            'bathrooms' => $this->bathrooms,
            'country' => $this->country,
            'zipcode' => $this->zipcode,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'medicalno' => $this->medicalno,
            'fireno' => $this->fireno,
            'policeno' => $this->policeno,
            'currency' => $this->currency,
            'startdate' => $this->startdate,
            'enddate' => $this->enddate,
            'minstay' => $this->minstay,
            'maxstay' => $this->maxstay,
            'advancenotice' => $this->advancenotice,
        ]);

        $query->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'listingname', $this->listingname])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'streetaddress', $this->streetaddress])
            ->andFilterWhere(['like', 'accesscode', $this->accesscode])
            ->andFilterWhere(['like', 'state', $this->state])
            ->andFilterWhere(['like', 'commonamenities', $this->commonamenities])
            ->andFilterWhere(['like', 'additionalamenities', $this->additionalamenities])
            ->andFilterWhere(['like', 'specialfeatures', $this->specialfeatures])
            ->andFilterWhere(['like', 'safetychecklist', $this->safetychecklist])
            ->andFilterWhere(['like', 'fireextinguisher', $this->fireextinguisher])
            ->andFilterWhere(['like', 'firealarm', $this->firealarm])
            ->andFilterWhere(['like', 'gasshutoffvalve', $this->gasshutoffvalve])
            ->andFilterWhere(['like', 'emergencyexitinstruction', $this->emergencyexitinstruction])
            ->andFilterWhere(['like', 'nightlyprice', $this->nightlyprice])
            ->andFilterWhere(['like', 'securitydeposit', $this->securitydeposit])
            ->andFilterWhere(['like', 'bookingstyle', $this->bookingstyle])
            ->andFilterWhere(['like', 'whocanbook', $this->whocanbook])
            ->andFilterWhere(['like', 'houserules', $this->houserules])
            ->andFilterWhere(['like', 'bookingavailability', $this->bookingavailability])
            ->andFilterWhere(['like', 'priceforextrapeople', $this->priceforextrapeople])
            ->andFilterWhere(['like', 'weeklydiscount', $this->weeklydiscount])
            ->andFilterWhere(['like', 'monthlydisocunt', $this->monthlydisocunt])
            ->andFilterWhere(['like', 'cancellation', $this->cancellation])
            ->andFilterWhere(['like', 'cdate', $this->cdate]);

        return $dataProvider;
    }
}
