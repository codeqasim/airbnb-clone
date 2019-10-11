<?php

namespace backend\models;

use Yii;
use backend\models\Profilereports;
use backend\models\Users;
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
class Userreports extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hts_userreports';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id','reportid','userid'], 'integer'],
            [['created_time'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'reportid' => 'Report ID',
            'userid' => 'User ID',
            'created_time' => 'Created time', 
            'report_status' => 'Report Status',
            'status' => 'Status',
        ];
    }

    /*
        Find all profilereports
    */
    public function finddAllreports()
    {
        return Userreports::find('all');
    }

    /*
        Get reportname
    */
    public function getReportname($id)
    {
        $getreport = Profilereports::find()->select('report')->where(['id'=>$id])->one();
        return $getreport->report;
    }

    /*
        Get Username
    */
    public function getUsername($id)
    {
        $getreport = Users::find()->select('firstname')->where(['id'=>$id])->one();
        return $getreport->firstname;
    }

}