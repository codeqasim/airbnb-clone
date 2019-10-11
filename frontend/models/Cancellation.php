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
class Cancellation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hts_cancellation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cancelfrom', 'cancelto','cancelpercentage'], 'integer'],
            [['policyname'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'policyname' => 'Policy Name',
            'policylimit' => 'Policy Limit',
            'cancelfrom' => 'Cancel From',
            'cancelto' => 'Cancel To', 
            'cancelpercentage' => 'Cancel Percentages',
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
