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
class Claim extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hts_claim';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userid', 'reservationid'], 'integer'],
            [['sdamount', 'sdstatus','claimby'], 'string', 'max' => 10],
            [['claimstatus', 'receiverstatus'], 'string', 'max' => 20]
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
            'reservationid' => 'Reservationid',
            'sdamount' => 'Sdamount',
            'sdstatus' => 'Sdstatus', 
            'claimby' => 'Claimby',
            'claimstatus' => 'Claimstatus',
            'receiverstatus' => 'Receiverstatus',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReservation()
    {
        return $this->hasOne(Reservations::className(), ['id' => 'reservationid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'userid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClaimmessages()
    {
        return $this->hasMany(Claimmessage::className(), ['claimid' => 'id']);
    }
}
