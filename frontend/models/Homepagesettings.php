<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "hts_homepagesettings".
 *
 * @property integer $id
 * @property string $banner
 * @property string $bannertitle
 * @property string $bannerdesc
 * @property integer $placescount
 * @property string $placesdesc
 * @property integer $customerscount
 * @property string $customersdesc
 * @property string $supporttime
 * @property string $supportdesc
 */
class Homepagesettings extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hts_homepagesettings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['banner', 'bannertitle', 'bannerdesc', 'placescount', 'placesdesc', 'customerscount', 'customersdesc', 'supporttime', 'supportdesc'], 'required'],
            [['placescount', 'customerscount'], 'integer'],
            [['banner'], 'string', 'max' => 30],
            [['bannertitle'], 'string', 'max' => 50],
            [['bannerdesc'], 'string', 'max' => 200],
            [['placesdesc', 'customersdesc', 'supportdesc'], 'string', 'max' => 250],
            [['supporttime'], 'string', 'max' => 5]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'banner' => 'Banner',
            'bannertitle' => 'Bannertitle',
            'bannerdesc' => 'Bannerdesc',
            'placescount' => 'Placescount',
            'placesdesc' => 'Placesdesc',
            'customerscount' => 'Customerscount',
            'customersdesc' => 'Customersdesc',
            'supporttime' => 'Supporttime',
            'supportdesc' => 'Supportdesc',
        ];
    }
}
