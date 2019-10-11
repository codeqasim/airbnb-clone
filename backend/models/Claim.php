<?php

namespace backend\models;

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
            [['reservationid'], 'integer'],
            [['sdamount', 'sdstatus','claimby','userid'], 'string', 'max' => 10],
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
    
    public function getInvoices()
    {
        return $this->hasOne(Invoices::className(), ['orderid' => 'reservationid']);
    }    

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'userid'])->from(['user' => Users::tableName()]);
    }
    
    public function getReservations($id)
    {
        return Reservations::find()->where(['id'=>$id])->one();
    }    
    
    public function getHost($hostid)
    {
        $data = Users::find()->where(['id'=>$hostid])->one();
        if(!empty($data))
        return $data->firstname;
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClaimmessages()
    {
        return $this->hasMany(Claimmessage::className(), ['claimid' => 'id']);
    }
    
    public function getmessages($id)
    {
        return Claimmessage::find()->where(['claimid'=>$id])->one();
    }
}
