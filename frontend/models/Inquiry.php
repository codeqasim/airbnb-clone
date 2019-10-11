<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "hts_inquiry".
 *
 * @property integer $id
 * @property integer $senderid
 * @property integer $receiverid
 * @property integer $lastmessageid
 * @property integer $listingid
 * @property string $type
 * @property integer $checkin
 * @property integer $checkout
 * @property string $guest 
 * @property string $cdate
 * @property string $mdate
 *
 * @property Listing $listing
 * @property Users $receiver
 * @property Users $sender
 */
class Inquiry extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hts_inquiry';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['senderid', 'receiverid', 'lastmessageid', 'listingid', 'guest'], 'integer'],
            [['cdate','mdate'], 'safe']         
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'senderid' => 'Senderid',
            'receiverid' => 'Receiverid',
            'lastmessageid' => 'Lastmessageid',
            'listingid' => 'Listingid',
            'type' => 'Type',
            'guest' => 'Guests',
            'cdate' => 'Cdate',
            'mdate' => 'mdate',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getListing()
    {
        return $this->hasOne(Listing::className(), ['id' => 'listingid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceiver()
    {
        return $this->hasOne(Users::className(), ['id' => 'receiverid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSender()
    {
        return $this->hasOne(Users::className(), ['id' => 'senderid']);
    }
    
}
