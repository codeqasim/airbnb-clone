<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "hts_messages".
 *
 * @property integer $id
 * @property integer $inquiryid
 * @property integer $senderid
 * @property integer $receiverid
 * @property string $message
 * @property integer $receiverread
 * @property integer $listingid
 * @property string $messagetype
 *
 * @property Listing $listing
 * @property Users $receiver
 * @property Users $sender
 */
class Messages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hts_messages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['inquiryid', 'senderid', 'receiverid', 'receiverread', 'listingid'], 'integer'],
            [['message', 'messagetype'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'inquiryid' => 'Inquiryid',
            'senderid' => 'Senderid',
            'receiverid' => 'Receiverid',
            'message' => 'Message',
            'receiverread' => 'Receiverread',
            'listingid' => 'Listingid',
            'messagetype' => 'Messagetype',
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
