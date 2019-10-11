<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "hts_claimmessage".
 *
 * @property integer $id
 * @property integer $claimid
 * @property integer $userid
 * @property integer $hostid
 * @property string $message
 * @property string $sentby
 * @property string $cdate
 *
 * @property Claim $claim
 * @property Users $host
 * @property Users $user
 */
class Claimmessage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hts_claimmessage';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['claimid', 'userid', 'hostid'], 'integer'],
            [['message'], 'string'],
            [['sentby'], 'required'],
            [['cdate'], 'safe'],
            [['sentby'], 'string', 'max' => 6]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'claimid' => 'Claimid',
            'userid' => 'Userid',
            'hostid' => 'Hostid',
            'message' => 'Message',
            'sentby' => 'Sentby',
            'cdate' => 'Cdate',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClaim()
    {
        return $this->hasOne(Claim::className(), ['id' => 'claimid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHost()
    {
        return $this->hasOne(Users::className(), ['id' => 'hostid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'userid']);
    }
}
