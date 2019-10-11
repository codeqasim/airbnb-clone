<?php

namespace backend\models;

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
	
	public $countryDetails;
	public $currencyDetails;
	
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
            [['price'], 'required'],
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
            'countrycode' => 'Country code',
            'currencycode' => 'Currency code',
            'currencysymbol' => 'Currency symbol',
            'countryname' => 'Country name',
            'currencyname' => 'Currency name',
            'price' => 'Price',
            'status' => 'Status',
            'cdate' => 'Created date',
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
