<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "hts_userdevices".
 *
 * @property integer $id
 * @property string $deviceToken
 * @property integer $user_id
 * @property integer $badge
 * @property integer $type
 * @property integer $mode
 * @property integer $cdate
 * @property string $deviceId
 */
class Userdevices extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hts_userdevices';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'badge', 'type', 'mode', 'cdate'], 'integer'],
            [['type', 'mode', 'deviceId'], 'required'],
            [['deviceToken', 'deviceId'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'deviceToken' => 'Device Token',
            'user_id' => 'User ID',
            'badge' => 'Badge',
            'type' => 'Type',
            'mode' => 'Mode',
            'cdate' => 'Cdate',
            'deviceId' => 'Device ID',
        ];
    }
}
