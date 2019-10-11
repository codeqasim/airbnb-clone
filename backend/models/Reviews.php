<?php

namespace backend\models;
use backend\models\Users;

use Yii;

/**
 * This is the model class for table "hts_reviews".
 *
 * @property integer $id
 * @property integer $userid
 * @property integer $reservationid
 * @property integer $rating
 * @property string $review
 * @property integer $listid
 *
 * @property Listing $list
 * @property Reservations $reservation
 * @property Users $user
 */
class Reviews extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hts_reviews';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userid', 'reservationid', 'rating', 'listid'], 'integer'],
            [['review'], 'string', 'max' => 250]
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
            'reservationid' => 'Reservationid',
            'rating' => 'Rating',
            'review' => 'Review',
            'listid' => 'Listid',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getList()
    {
        return $this->hasOne(Listing::className(), ['id' => 'listid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReservation()
    {
        return $this->hasOne(Reservations::className(), ['id' => 'reservationid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'userid']);
    }

    public function getRatingbylisting( $listid )
    {
        $getreviewbylist = Reviews::find()->where(['listid'=>$listid])->all();

        if(!empty($getreviewbylist))
        {
            $n = count($getreviewbylist);
            $max = 0;

            foreach ($getreviewbylist as $rate => $count) { // iterate through array
                $max = $max+$count['rating'];
            }
            $review['rating'] = $max / $n;
            $review['n_rating'] = $n;
            
        }else{
            $review['rating'] = 0;
            $review['n_rating'] = 0;
        }
        return $review;
    }

    public function getRatingbyuser( $userid )
    {
        $getreviewbylist = Reviews::find()->where(['userid'=>$userid])->all();

        if(!empty($getreviewbylist))
        {
            $n = count($getreviewbylist);
            $max = 0;

            foreach ($getreviewbylist as $rate => $count) { // iterate through array
                $max = $max+$count['rating'];
            }
            $review['rating'] = $max / $n;
            $review['n_rating'] = $n;
            
        }else{
            $review['rating'] = 0;
            $review['n_rating'] = 0;
        }
        return $review;
    }

    public function getUserbyreview( $userid )
    {
        $getusername = Users::find()->select('firstname')->where(['id' => $userid])->one();
        return $getusername->firstname;
    }

    public function getListbyreview( $listid )
    {
        $getlistingname = Listing::find()->select('listingname')->where(['id' => $listid])->one();
        return $getlistingname->listingname;
    }
}
