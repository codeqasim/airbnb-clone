<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "hts_help".
 *
 * @property integer $id
 * @property string $name
 * @property string $maincontent
 * @property string $subcontent
 */
class Help extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hts_help';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'maincontent', 'subcontent'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'maincontent' => 'Maincontent',
            'subcontent' => 'Subcontent',
        ];
    }
}
