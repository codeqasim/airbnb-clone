<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "hts_country".
 *
 * @property integer $id
 * @property string $code
 * @property string $countryname
 *
 * @property Users[] $users
 */
class Country extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hts_country';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code'], 'string', 'max' => 3],
            [['countryname'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'countryname' => 'Countryname',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(Users::className(), ['country' => 'id']);
    }
    
    public function getCountry()
    {
        return static::findOne(['id' => "1"]);
    }
}
