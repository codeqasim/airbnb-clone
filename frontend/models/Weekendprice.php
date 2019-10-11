<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "hts_claim".
 *
 * @property integer $id
 * @property integer $userid
 * @property integer $reservationid
 * @property string $claimby
 * @property string $claimstatus
 * @property string $receiverstatus
 *
 * @property Reservations $reservation
 * @property Users $user
 * @property Claimmessage[] $claimmessages
 */
class Weekendprice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hts_weekendprice';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id','listid','weekend_price'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'listid' => 'List ID',
            'weekend_price' => 'Weekend Price',
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
