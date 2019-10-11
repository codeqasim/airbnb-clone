<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "hts_lists".
 *
 * @property integer $id
 * @property string $listname
 * @property integer $createdby
 * @property integer $cdate
 *
 * @property Users $createdby0
 * @property Wishlists[] $wishlists
 */
class Lists extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hts_lists';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['createdby', 'user_create'], 'integer'],
            [['cdate'], 'safe'],
            [['listname'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'listname' => 'Listname',
            'createdby' => 'Createdby',
            'user_create' => 'User Create', 
            'cdate' => 'Cdate',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedby0()
    {
        return $this->hasOne(Users::className(), ['id' => 'createdby']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWishlists()
    {
        return $this->hasMany(Wishlists::className(), ['listid' => 'id']);
    }
}
