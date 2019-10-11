<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "hts_claim".
 *
 * @property integer $id
 * @property integer $userid
 * @property integer $reservationid
 * @property string $claimby
 * @property string $claimstatus
 * @property string $receiverstatus
 *
 * @property Reservations $reservation
 * @property Users $user
 * @property Claimmessage[] $claimmessages
 */
class Calendar extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hts_calendar';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id','listid'], 'integer'],
            [['notes', 'status','liststatus'], 'string', 'max' => 10]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'listid' => 'List ID',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'liststatus' => 'List status', 
            'price' => 'Price',
            'notes' => 'Notes',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'userid']);
    }

    public function getDatelist($startDate, $endDate)
    {
        $start    = strtotime($startDate);
        $end    = strtotime($endDate); 

        $disableddates = array();
        while($start <= $end)
        {
            array_push(
                $disableddates,
                date('Y-m-d',
                    $start)
            );
           $start += 86400;
        }
        return $disableddates;
    }
}
