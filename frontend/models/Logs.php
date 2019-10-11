<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "hts_logs".
 *
 * @property integer $id
 * @property string $type
 * @property integer $userid
 * @property integer $notifyto
 * @property integer $listingid
 * @property string $notifymessage
 * @property string $message
 * @property integer $cdate
 *
 * @property Listing $listing
 * @property Users $notifyto0
 * @property Users $user
 */
class Logs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hts_logs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userid', 'notifyto', 'listingid', 'cdate'], 'integer'],
            [['notifymessage'], 'required'],
            [['notifymessage', 'message'], 'string'],
            [['type'], 'string', 'max' => 10]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'userid' => 'Userid',
            'notifyto' => 'Notifyto',
            'listingid' => 'Listingid',
            'notifymessage' => 'Notifymessage',
            'message' => 'Message',
            'cdate' => 'Cdate',
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
    public function getNotifyto0()
    {
        return $this->hasOne(Users::className(), ['id' => 'notifyto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'userid']);
    }
}
