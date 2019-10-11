<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "hts_currency".
 *
 * @property integer $id
 * @property string $countrycode
 * @property string $currencycode
 * @property string $currencysymbol
 * @property string $countryname
 * @property string $currencyname
 * @property string $price
 * @property string $status
 * @property integer $cdate
 *
 * @property Listing[] $listings
 */
class Currency extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hts_currency';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cdate'], 'integer'],
            [['countrycode', 'price', 'status'], 'string', 'max' => 10],
            [['currencycode'], 'string', 'max' => 3],
            [['currencysymbol'], 'string', 'max' => 5],
            [['countryname', 'currencyname'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'countrycode' => 'Countrycode',
            'currencycode' => 'Currencycode',
            'currencysymbol' => 'Currencysymbol',
            'countryname' => 'Countryname',
            'currencyname' => 'Currencyname',
            'price' => 'Price',
            'status' => 'Status',
            'cdate' => 'Cdate',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getListings()
    {
        return $this->hasMany(Listing::className(), ['currency' => 'id']);
    }
}
