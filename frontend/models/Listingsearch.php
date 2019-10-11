<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Listing;

/**
 * Listingsearch represents the model behind the search form about `frontend\models\Listing`.
 */
class Listingsearch extends Listing
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'userid', 'hometype', 'roomtype', 'accommodates', 'bedrooms', 'beds', 'bathrooms', 'country', 'zipcode', 'commonamenities', 'additionalamenities', 'specialfeatures', 'safetychecklist', 'medicalno', 'fireno', 'policeno', 'currency', 'startdate', 'enddate', 'minstay', 'maxstay', 'advancenotice', 'liststatus'], 'integer'],
            [['city', 'listingname', 'description', 'streetaddress', 'accesscode', 'state', 'fireextinguisher', 'firealarm', 'gasshutoffvalve', 'emergencyexitinstruction', 'nightlyprice', 'bookingstyle', 'whocanbook', 'houserules', 'bookingavailability', 'priceforextrapeople', 'weeklydiscount', 'monthlydisocunt', 'cancellation', 'cdate'], 'safe'],
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

        $query->andFilterWhere([
            'id' => $this->id,
            'userid' => $this->userid,
            'hometype' => $this->hometype,
            'roomtype' => $this->roomtype,
            'accommodates' => $this->accommodates,
            'bedrooms' => $this->bedrooms,
            'beds' => $this->beds,
            'bathrooms' => $this->bathrooms,
            'country' => $this->country,
            'zipcode' => $this->zipcode,
            'commonamenities' => $this->commonamenities,
            'additionalamenities' => $this->additionalamenities,
            'specialfeatures' => $this->specialfeatures,
            'safetychecklist' => $this->safetychecklist,
            'medicalno' => $this->medicalno,
            'fireno' => $this->fireno,
            'policeno' => $this->policeno,
            'currency' => $this->currency,
            'startdate' => $this->startdate,
            'enddate' => $this->enddate,
            'minstay' => $this->minstay,
            'maxstay' => $this->maxstay,
            'advancenotice' => $this->advancenotice,
            'liststatus' => $this->liststatus,
        ]);

        $query->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'listingname', $this->listingname])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'streetaddress', $this->streetaddress])
            ->andFilterWhere(['like', 'accesscode', $this->accesscode])
            ->andFilterWhere(['like', 'state', $this->state])
            ->andFilterWhere(['like', 'fireextinguisher', $this->fireextinguisher])
            ->andFilterWhere(['like', 'firealarm', $this->firealarm])
            ->andFilterWhere(['like', 'gasshutoffvalve', $this->gasshutoffvalve])
            ->andFilterWhere(['like', 'emergencyexitinstruction', $this->emergencyexitinstruction])
            ->andFilterWhere(['like', 'nightlyprice', $this->nightlyprice])
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
