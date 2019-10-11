<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "hts_shippingaddress".
 *
 * @property integer $id
 * @property integer $userid
 * @property string $address1
 * @property string $address2
 * @property string $city
 * @property string $state
 * @property integer $country
 * @property string $zipcode
 *
 * @property Users $user
 */
class Shippingaddress extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hts_shippingaddress';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userid', 'country'], 'integer'],
            [['address1', 'address2'], 'string', 'max' => 60],
            [['city', 'state'], 'string', 'max' => 40],
            [['zipcode'], 'string', 'max' => 20]
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
            'address1' => 'Address1',
            'address2' => 'Address2',
            'city' => 'City',
            'state' => 'State',
            'country' => 'Country',
            'zipcode' => 'Zipcode',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'userid']);
    }
}
