<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "hts_specialfeatures".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $status
 * @property integer $cdate
 *
 * @property Listing[] $listings
 */
class Specialfeatures extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hts_specialfeatures';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cdate'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 100],
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
            'name' => 'Name',
            'description' => 'Description',
            'status' => 'Status',
            'specialimage' => 'Specialimage',
            'cdate' => 'Cdate',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getListings()
    {
        return $this->hasMany(Listing::className(), ['specialfeatures' => 'id']);
    }
    
    public function getSpeciallistings()
    {
    	return $this->hasMany(Speciallisting::className(), ['specialid' => 'id']);
    }    
}
