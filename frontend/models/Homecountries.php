<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "hts_homecountries".
 *
 * @property integer $id
 * @property integer $countryid
 * @property string $imagename
 * @property double $latitude
 * @property double $longitude
 *
 * @property Country $country
 */
class Homecountries extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hts_homecountries';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['countryid'], 'integer'],
            [['latitude', 'longitude'], 'number'],
            [['imagename'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'countryid' => 'Countryid',
            'imagename' => 'Imagename',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'countryid']);
    }
    
    public function getCountry0()
    {
    	return $this->hasOne(Country::className(), ['id' => 'country']);
    }    
    
    public static function findcountry($id)
    {
    	$country = Country::find()->where(['id'=>$id])->one();
    	return $country;
    }

    public function getHomecountries()
    {
        $homecountries = Yii::$app->db->createCommand("SELECT m.*,n.* 
                            FROM hts_homecountries AS m, hts_country AS n
                            WHERE m.countryid = n.id
                            ORDER BY m.id DESC")->queryAll();
        $countries = (object) $homecountries;
        return (object) $countries;
    }
}
