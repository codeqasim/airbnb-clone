<?php

namespace frontend\models;

use Yii;
//use yii\db\ActiveRecord;

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
class Profilereports extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hts_profilereports';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['created_time'], 'safe'],
            [['report_type','report','shortdesc'], 'required'],
            [['report','report_type'], 'string', 'max' => 60]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'report' => 'Report',
            'report_type' => 'Report type',
            'shortdesc' => 'Short descriptions',
            'created_time' => 'Created time', 
            'status' => 'Status',
        ];
    }

    /*
        Find all profilereports
    */
    public function finddAllreports()
    {
        return Profilereports::find('all');
    }

}