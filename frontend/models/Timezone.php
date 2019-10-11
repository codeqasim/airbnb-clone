<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "hts_timezone".
 *
 * @property integer $id
 * @property string $countryname
 * @property string $code
 * @property string $timezone
 * @property string $zonecode
 */
class Timezone extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hts_timezone';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['countryname', 'timezone'], 'required'],
            [['countryname'], 'string', 'max' => 50],
            [['code'], 'string', 'max' => 3],
            [['timezone'], 'string', 'max' => 75]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'countryname' => 'Countryname',
            'code' => 'Code',
            'timezone' => 'Timezone',
            'zonecode' => 'Zonecode', 
        ];
    }
}
