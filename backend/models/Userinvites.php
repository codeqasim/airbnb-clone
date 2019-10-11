<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "hts_userinvites".
 *
 * @property integer $id
 * @property integer $userid
 * @property string $invitedemail
 * @property integer $inviteddate
 * @property string $status
 * @property integer $cdate
 *
 * @property Users $user
 */
class Userinvites extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hts_userinvites';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userid', 'inviteddate', 'cdate'], 'integer'],
            [['invitedemail'], 'string', 'max' => 150],
            [['status'], 'string', 'max' => 10]
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
            'invitedemail' => 'Invitedemail',
            'inviteddate' => 'Inviteddate',
            'status' => 'Status',
            'cdate' => 'Cdate',
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
