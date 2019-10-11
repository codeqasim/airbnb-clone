<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "hts_buttonsliders".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $buttonname
 * @property string $buttonlink
 * @property string $sliderimage
 */
class Buttonsliders extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hts_buttonsliders';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'description', 'buttonname', 'buttonlink', 'sliderimage'], 'required'],
            [['buttonlink'], 'string'],
            [['title', 'buttonname'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 100],
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
            'title' => 'Title',
            'description' => 'Description',
            'buttonname' => 'Buttonname',
            'buttonlink' => 'Buttonlink',
            'sliderimage' => 'Sliderimage',
        ];
    }
}
