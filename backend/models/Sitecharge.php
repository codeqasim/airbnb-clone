<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "hts_sitecharge".
 *
 * @property integer $id
 * @property string $min_value
 * @property string $max_value
 * @property string $percentage
 */
class Sitecharge extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hts_sitecharge';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['min_value', 'max_value'], 'string', 'max' => 15],
            [['percentage'], 'string', 'max' => 3]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'min_value' => 'Min Value',
            'max_value' => 'Max Value',
            'percentage' => 'Percentage',
        ];
    }
}
