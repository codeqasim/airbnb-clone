<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "hts_photos".
 *
 * @property integer $id
 * @property integer $listid
 * @property string $image_name
 *
 * @property Listing $list
 */
class Photos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hts_photos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['listid'], 'integer'],
            [['image_name'], 'string', 'max' => 40]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'listid' => 'Listid',
            'image_name' => 'Image Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getList()
    {
        return $this->hasOne(Listing::className(), ['id' => 'listid']);
    }
}
