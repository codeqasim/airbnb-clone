<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "hts_additionallisting".
 *
 * @property integer $id
 * @property integer $listingid
 * @property integer $amenityid
 *
 * @property Additionalamenities $amenity
 * @property Listing $listing
 */
class Additionallisting extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hts_additionallisting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['listingid', 'amenityid'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'listingid' => 'Listingid',
            'amenityid' => 'Amenityid',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAmenity()
    {
        return $this->hasOne(Additionalamenities::className(), ['id' => 'amenityid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getListing()
    {
        return $this->hasOne(Listing::className(), ['id' => 'listingid']);
    }
}
