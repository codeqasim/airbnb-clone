<?php

namespace backend\models;

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
            [['countryid'], 'string'],
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
}
