<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "hts_safetylisting".
 *
 * @property integer $id
 * @property integer $listingid
 * @property integer $safetyid
 *
 * @property Safetycheck $safety
 * @property Listing $listing
 */
class Safetylisting extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hts_safetylisting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['listingid', 'safetyid'], 'integer']
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
            'safetyid' => 'Safetyid',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSafety()
    {
        return $this->hasOne(Safetycheck::className(), ['id' => 'safetyid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getListing()
    {
        return $this->hasOne(Listing::className(), ['id' => 'listingid']);
    }
}
