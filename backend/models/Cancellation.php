<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "hts_cancellation".
 *
 * @property integer $id
 * @property integer $cancelfrom
 * @property integer $cancelto
 * @property integer $cancelpercentage
 * @property string $canceldesc
 */
class Cancellation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hts_cancellation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['policyname','policylimit', 'cancelfrom', 'cancelto', 'cancelpercentage', 'canceldesc'], 'required'],
            [['cancelfrom', 'cancelto', 'cancelpercentage'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'policyname' => 'Policy Name',
            'policylimit' => 'Policy Limit',
            'cancelfrom' => 'Cancelfrom',
            'cancelto' => 'Cancelto',
            'cancelpercentage' => 'Cancelpercentage',
            'canceldesc' => 'Canceldescription',
        ];
    }

    public function getListingCancellation()  
    {
        return $this->hasMany(Listing::className(), ['cancellation' => 'id']); 
    }

}
