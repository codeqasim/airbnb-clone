<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "hts_help".
 *
 * @property integer $id
 * @property string $name
 * @property string $maincontent
 * @property string $subcontent
 */
class Helptopic extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hts_helptopic';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['topic', 'maincontent', 'subcontent'], 'string'],
			[['topic', 'maincontent', 'subcontent'], 'required']];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'topic' => 'Topic name',
        ];
    }
}
