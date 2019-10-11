<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "hts_hometype".
 *
 * @property integer $id
 * @property string $hometype
 * @property integer $priority  
 *
 * @property Listing[] $listings
 */
class Hometype extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hts_hometype';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['priority'], 'integer'],    
            [['hometype'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'hometype' => 'Hometype',
            'priority' => 'Priority', 
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getListings()
    {
        return $this->hasMany(Listing::className(), ['hometype' => 'id']);
    }
    
    public static function findallidentity()
    {
         $user = Hometype::find('all')->all();
		 return $user;
    }    
}
