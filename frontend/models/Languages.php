<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "hts_languages".
 *
 * @property integer $id
 * @property string $languagename
 */
class Languages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hts_languages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'languagename'], 'required'],
            [['id'], 'integer'],
            [['languagename'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'languagename' => 'Languagename',
        ];
    }
}
