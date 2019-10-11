<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "hts_textsliders".
 *
 * @property integer $id
 * @property string $slidertext
 * @property string $sliderimage
 */
class Textsliders extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hts_textsliders';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['slidertext', 'sliderimage'], 'required'],
            [['slidertext'], 'string', 'max' => 100],
            [['sliderimage'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'slidertext' => 'Slidertext',
            'sliderimage' => 'Sliderimage',
        ];
    }
}
