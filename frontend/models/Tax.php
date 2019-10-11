<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "hts_tax".
 *
 * @property integer $id
 * @property integer $countryid
 * @property string $countryname
 * @property string $taxname
 * @property string $percentage
 *
 * @property Country $country
 */
class Tax extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hts_tax';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['countryid'], 'integer'],
            [['countryname', 'taxname'], 'string', 'max' => 50],
            [['percentage'], 'string', 'max' => 3]
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
            'countryname' => 'Countryname',
            'taxname' => 'Taxname',
            'percentage' => 'Percentage',
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
