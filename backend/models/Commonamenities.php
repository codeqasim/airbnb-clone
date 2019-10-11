<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "hts_commonamenities".
 *
 * @property integer $id
 * @property string $name
 * @property string $status
 * @property integer $cdate
 *
 * @property Listing[] $listings
 */
class Commonamenities extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hts_commonamenities';
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
			'description'=> 'Description',
            'status' => 'Status',
            'cdate' => 'Cdate',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getListings()
    {
        return $this->hasMany(Listing::className(), ['commonamenities' => 'id']);
    }
    
    public static function findallidentity()
    {
         $user = Commonamenities::find('all')->all();
		 return $user;
    }   

    public function getCommonlistings()
    {
    	return $this->hasMany(Commonlisting::className(), ['amenityid' => 'id']);
    }    
}
