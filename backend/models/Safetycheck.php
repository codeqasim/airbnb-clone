<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "hts_safetycheck".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $status
 * @property integer $cdate
 *
 * @property Listing[] $listings
 */
class Safetycheck extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hts_safetycheck';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cdate'], 'integer'],
            [['name'], 'string', 'max' => 50],
            ['name', 'required','on'=>'safetycheck'],
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
            'cdate' => 'Cdate',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getListings()
    {
        return $this->hasMany(Listing::className(), ['safetychecklist' => 'id']);
    }
    
    public function getSafetylistings()
    {
    	return $this->hasMany(Safetylisting::className(), ['safetyid' => 'id']);
    }    
}
