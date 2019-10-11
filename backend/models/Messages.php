<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "hts_messages".
 *
 * @property integer $id
 * @property integer $senderid
 * @property integer $receiverid
 * @property string $message
 * @property integer $receiverread
 * @property string $messagetype
 *
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
            [['senderid', 'receiverid', 'receiverread'], 'integer'],
            [['message', 'messagetype'], 'string'],
            [['messagetype'], 'required']
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
            'message' => 'Message',
            'receiverread' => 'Receiverread',
            'messagetype' => 'Messagetype',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSender()
    {
        return $this->hasOne(Users::className(), ['id' => 'senderid']);
    }
}
