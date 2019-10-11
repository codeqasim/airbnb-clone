<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "hts_listingproperties".
 *
 * @property integer $id
 * @property integer $bedrooms
 * @property integer $beds
 * @property integer $bathrooms
 * @property integer $accommodates
 *
 * @property Listing[] $listings
 * @property Listing[] $listings0
 * @property Listing[] $listings1
 * @property Listing[] $listings2
 */
class Listingproperties extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hts_listingproperties';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bedrooms', 'beds', 'bathrooms', 'accommodates'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bedrooms' => 'Bedrooms',
            'beds' => 'Beds',
            'bathrooms' => 'Bathrooms',
            'accommodates' => 'Accommodates',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getListings()
    {
        return $this->hasMany(Listing::className(), ['accommodates' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getListings0()
    {
        return $this->hasMany(Listing::className(), ['bathrooms' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getListings1()
    {
        return $this->hasMany(Listing::className(), ['bedrooms' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getListings2()
    {
        return $this->hasMany(Listing::className(), ['beds' => 'id']);
    }
    
    public static function findIdentity()
    {
         $user = Listingproperties::find()->where(['id' => '1'])->one();
		 return $user;
    }	    
}
