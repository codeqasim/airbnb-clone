<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "hts_wishlists".
 *
 * @property integer $id
 * @property integer $userid
 * @property integer $listid
 * @property integer $listingid
 *
 * @property Lists $list
 * @property Listing $listing
 * @property Users $user
 */
class Wishlists extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hts_wishlists';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userid', 'listid', 'listingid'], 'integer']
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
            'listid' => 'Listid',
            'listingid' => 'Listingid',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getList()
    {
        return $this->hasOne(Lists::className(), ['id' => 'listid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getListing()
    {
        return $this->hasOne(Listing::className(), ['id' => 'listingid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'userid']);
    }
}
