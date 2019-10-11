<?php

namespace backend\models;

use Yii;
//use yii\db\ActiveRecord;

/**
 * This is the model class for table "hts_lists".
 *
 * @property integer $id
 * @property string $listname
 * @property integer $createdby
 * @property integer $cdate
 *
 * @property Users $createdby0
 * @property Wishlists[] $wishlists
 */
class Roleandprivilige extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hts_roles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['created_time'], 'safe'],
            [['name'], 'unique'],
            [['name','description'], 'string', 'max' => 150],
            [['name','description','roles'],'required']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Role Name',
            'description' => 'Role Description',
            'roles' => 'Assign Roles',
            'created_time' => 'Created time', 
            'status' => 'Status',
        ];
    }

    /*
        Find all profilereports
    */
    public function finddAllreports()
    {
        return Roleandprivilige::find('all');
    }

}