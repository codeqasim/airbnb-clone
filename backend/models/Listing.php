<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "hts_listing".
 *
 * @property integer $id
 * @property integer $userid
 * @property integer $hometype
 * @property integer $roomtype
 * @property integer $accommodates
 * @property integer $bedrooms
 * @property integer $beds
 * @property integer $bathrooms
 * @property string $city
 * @property string $listingname
 * @property string $description
 * @property Country $country0
 * @property string $streetaddress
 * @property string $accesscode
 * @property string $state
 * @property string $zipcode
 * @property integer $commonamenities
 * @property integer $additionalamenities
 * @property integer $specialfeatures
 * @property integer $safetychecklist
 * @property string $fireextinguisher
 * @property string $firealarm
 * @property string $gasshutoffvalve
 * @property string $emergencyexitinstruction
 * @property string $medicalno
 * @property string $fireno
 * @property string $policeno
 * @property string $nightlyprice
 * @property string $hourlyprice
 * @property integer $currency
 * @property string $bookingstyle
 * @property string $whocanbook
 * @property string $houserules
 * @property string $bookingavailability
 * @property integer $startdate
 * @property integer $enddate
 * @property integer $minstay
 * @property integer $maxstay
 * @property integer $advancenotice
 * @property string $priceforextrapeople
 * @property string $weeklydiscount
 * @property string $monthlydisocunt
 * @property string $cancellation
 * @property integer $liststatus
 * @property string $cdate
 *
 * @property Listingproperties $accommodates0
 * @property Additionalamenities $additionalamenities0
 * @property Listingproperties $bathrooms0
 * @property Listingproperties $bedrooms0
 * @property Listingproperties $beds0
 * @property Commonamenities $commonamenities0
 * @property Currency $currency0
 * @property Hometype $hometype0
 * @property Users $user
 * @property Roomtype $roomtype0
 * @property Safetycheck $safetychecklist0
 * @property Specialfeatures $specialfeatures0
 * @property Photos[] $photos
 */
class Listing extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hts_listing';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userid', 'hometype', 'roomtype', 'accommodates', 'bedrooms', 'beds', 'bathrooms', 'country', 'zipcode', 'medicalno', 'fireno', 'policeno', 'currency', 'startdate', 'enddate', 'minstay', 'maxstay', 'advancenotice', 'liststatus'], 'integer'],
            [['commonamenities', 'additionalamenities', 'specialfeatures', 'safetychecklist'],'string'],
            [['houserules'], 'string'],
            [['latitude','longitude'],'number'],
            [['city', 'state'], 'string', 'max' => 40],
            [['listingname'], 'string', 'max' => 35],
            [['description', 'fireextinguisher', 'firealarm', 'gasshutoffvalve', 'emergencyexitinstruction'], 'string', 'max' => 250],
            [['streetaddress'], 'string', 'max' => 100],
            [['accesscode'], 'string', 'max' => 50],
            [['nightlyprice', 'hourlyprice', 'securitydeposit','bookingstyle', 'whocanbook', 'bookingavailability', 'priceforextrapeople', 'cancellation'], 'string', 'max' => 10],
            [['weeklydiscount', 'monthlydisocunt'], 'string', 'max' => 5],
            [['cdate'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userid' => 'Userid',
            'hometype' => 'Hometype',
            'roomtype' => 'Roomtype',
            'accommodates' => 'Accommodates',
            'bedrooms' => 'Bedrooms',
            'beds' => 'Beds',
            'bathrooms' => 'Bathrooms',
            'city' => 'City',
            'listingname' => 'Listingname',
            'description' => 'Description',
            'country' => 'Country',
            'streetaddress' => 'Streetaddress',
            'accesscode' => 'Accesscode',
            'state' => 'State',
            'zipcode' => 'Zipcode',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'commonamenities' => 'Commonamenities',
            'additionalamenities' => 'Additionalamenities',
            'specialfeatures' => 'Specialfeatures',
            'safetychecklist' => 'Safetychecklist',
            'fireextinguisher' => 'Fireextinguisher',
            'firealarm' => 'Firealarm',
            'gasshutoffvalve' => 'Gasshutoffvalve',
            'emergencyexitinstruction' => 'Emergencyexitinstruction',
            'medicalno' => 'Medicalno',
            'fireno' => 'Fireno',
            'policeno' => 'Policeno',
            'nightlyprice' => 'Nightlyprice',
            'hourlyprice' => 'Hourlyprice', 
            'securitydeposit' => 'Securitydeposit',
            'currency' => 'Currency',
            'bookingstyle' => 'Bookingstyle',
            'whocanbook' => 'Whocanbook',
            'houserules' => 'Houserules',
            'bookingavailability' => 'Bookingavailability',
            'startdate' => 'Startdate',
            'enddate' => 'Enddate',
            'minstay' => 'Minstay',
            'maxstay' => 'Maxstay',
            'advancenotice' => 'Advancenotice',
            'priceforextrapeople' => 'Priceforextrapeople',
            'weeklydiscount' => 'Weeklydiscount',
            'monthlydisocunt' => 'Monthlydisocunt',
            'cancellation' => 'Cancellation',
            'liststatus' => 'Liststatus',
            'cdate' => 'Cdate',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccommodates0()
    {
        return $this->hasOne(Listingproperties::className(), ['id' => 'accommodates']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */    
     public function getCountry0()
     {
         return $this->hasOne(Country::className(), ['id' => 'country']);
     }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdditionalamenities0()
    {
        return $this->hasOne(Additionalamenities::className(), ['id' => 'additionalamenities']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBathrooms0()
    {
        return $this->hasOne(Listingproperties::className(), ['id' => 'bathrooms']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBedrooms0()
    {
        return $this->hasOne(Listingproperties::className(), ['id' => 'bedrooms']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBeds0()
    {
        return $this->hasOne(Listingproperties::className(), ['id' => 'beds']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCommonamenities0()
    {
        return $this->hasOne(Commonamenities::className(), ['id' => 'commonamenities']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrency0()
    {
        return $this->hasOne(Currency::className(), ['id' => 'currency']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHometype0()
    {
        return $this->hasOne(Hometype::className(), ['id' => 'hometype']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'userid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoomtype0()
    {
        return $this->hasOne(Roomtype::className(), ['id' => 'roomtype']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSafetychecklist0()
    {
        return $this->hasOne(Safetycheck::className(), ['id' => 'safetychecklist']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpecialfeatures0()
    {
        return $this->hasOne(Specialfeatures::className(), ['id' => 'specialfeatures']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPhotos()
    {
        return $this->hasMany(Photos::className(), ['listid' => 'id']);
    }
}
