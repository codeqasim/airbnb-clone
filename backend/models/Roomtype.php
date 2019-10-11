<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "hts_roomtype".
 *
 * @property integer $id
 * @property string $roomtype
 *
 * @property Listing[] $listings
 */
class Roomtype extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hts_roomtype';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['roomtype'], 'string', 'max' => 45],
            [['description'], 'string', 'max' => 60],
            [['roomtype'], 'required', 'on'=>'room']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'roomtype' => 'Roomtype',
            'description' => 'Roomtype description',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getListings()
    {
        return $this->hasMany(Listing::className(), ['roomtype' => 'id']);
    }
}
