<?php

namespace backend\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "hts_additionalamenities".
 *
 * @property integer $id
 * @property string $name
 * @property string $status
 * @property integer $cdate
 *
 * @property Listing[] $listings
 */
class Additionalamenities extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hts_additionalamenities';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cdate'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 100],
            [['status'], 'string', 'max' => 10]
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
            'description' => 'Description',
            'status' => 'Status',
            'cdate' => 'Cdate',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getListings()
    {
        return $this->hasMany(Listing::className(), ['additionalamenities' => 'id']);
    }
    public static function findallidentity()
    {
         $user = Additionalamenities::find('all')->all();
		 return $user;
    }
    
    public function getAdditionallistings()
    {
    	return $this->hasMany(Additionallisting::className(), ['amenityid' => 'id']);
    }
    
    /*public function search()
    {
        // create ActiveQuery
        $query = Additionalamenities::find()->where(['<>', 'id', 0]);
        // Important: lets join the query with our previously mentioned relations
        // I do not make any other configuration like aliases or whatever, feel free
        // to investigate that your self
     
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination'=>['pageSize'=>10],
        ]);
     
        // Important: here is how we set up the sorting
        // The key is the attribute name on our "TourSearch" instance
        $dataProvider->sort->attributes['name'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['name' => SORT_ASC],
            'desc' => ['name' => SORT_DESC]
        ];

        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['like', 'name', $this->name])
              ->andFilterWhere(['like', 'descriptioin', $this->description]);
     
        return $dataProvider;
    }    */
	
 public function search($params)
    {
        $query = Additionalamenities::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination'=>['pageSize'=>10],
        ]);

        // load the seach form data and validate
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // adjust the query by adding the filters
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);
        return $dataProvider;
    }	
}
