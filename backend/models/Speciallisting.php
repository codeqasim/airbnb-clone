<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "hts_speciallisting".
 *
 * @property integer $id
 * @property integer $listingid
 * @property integer $specialid
 *
 * @property Specialfeatures $special
 * @property Listing $listing
 */
class Speciallisting extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hts_speciallisting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['listingid', 'specialid'], 'integer']
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
            'specialid' => 'Specialid',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpecial()
    {
        return $this->hasOne(Specialfeatures::className(), ['id' => 'specialid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getListing()
    {
        return $this->hasOne(Listing::className(), ['id' => 'listingid']);
    }
}
