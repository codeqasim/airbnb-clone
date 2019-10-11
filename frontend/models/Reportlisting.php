<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "hts_reportlisting".
 *
 * @property integer $id
 * @property integer $userid
 * @property integer $listingid
 * @property string $cdate
 */
class Reportlisting extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hts_reportlisting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userid', 'listingid','reportid'], 'required'],
            [['userid', 'listingid','reportid'], 'integer'],
            [['cdate'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userid' => 'Userid',
            'reportid' => 'Report Id',
            'listingid' => 'Listingid',
            'cdate' => 'Cdate',
        ];
    }
}
