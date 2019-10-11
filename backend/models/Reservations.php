<?php

namespace backend\models;
use backend\models\Cancellation;

use Yii;

/**
 * This is the model class for table "hts_reservations".
 *
 * @property integer $id
 * @property integer $userid
 * @property integer $hostid
 * @property integer $listid
 * @property integer $fromdate
 * @property integer $todate
 * @property integer $guests
 * @property string $pricepernight
 * @property integer $totaldays
 * @property integer $currencycode
 * @property string $commissionfees
 * @property string $servicefees
 * @property string $taxfees
 * @property string $securityfees
 * @property string $sdstatus 
 * @property string $total
 * @property string $booktype
 * @property string $bookstatus
 * @property string $cancelby
 * @property integer $canceldate 
 * @property string $orderstatus
  * @property string $claim_status
  * @property string $other_transaction
  * @property string $claim_transaction
 * @property string $cdate
 *
 * @property Claim[] $claims
 * @property Invoices[] $invoices
 * @property Users $user
 * @property Users $host
 * @property Listing $list
 * @property Users $user0
 */
class Reservations extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hts_reservations';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userid', 'hostid', 'listid', 'fromdate', 'todate', 'guests', 'totaldays','canceldate'], 'integer'],
            [['cdate','currencycode'], 'safe'],
            [['pricepernight', 'commissionfees', 'servicefees', 'taxfees', 'securityfees','sdstatus', 'total'],'safe'],
            [['booktype', 'bookstatus', 'orderstatus'], 'string', 'max' => 20],
            [['cancelby'], 'string', 'max' => 5]
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
            'hostid' => 'Hostid',
            'listid' => 'Listid',
            'fromdate' => 'Fromdate',
            'todate' => 'Todate',
            'guests' => 'Guests',
            'pricepernight' => 'Pricepernight',
            'totaldays' => 'Totaldays',
            'currencycode' => 'Currencycode', 
            'commissionfees' => 'Commissionfees',
            'servicefees' => 'Servicefees',
            'taxfees' => 'Taxfees',
            'securityfees' => 'Securityfees',
            'sdstatus' => 'Sdstatus',
            'total' => 'Total',
            'booktype' => 'Booktype',
            'bookstatus' => 'Bookstatus',
            'cancelby' => 'Cancelby',
            'canceldate' => 'Canceldate', 
            'orderstatus' => 'Orderstatus',
            'cdate' => 'Cdate',
        ];
    }
    
    /**
    * @return \yii\db\ActiveQuery
    */
    public function getClaims() 
    { 
        return $this->hasMany(Claim::className(), ['reservationid' => 'id']); 
    }     

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoices()
    {
        return $this->hasOne(Invoices::className(), ['orderid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'userid'])->from(['user' => Users::tableName()]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHost()
    {
        return $this->hasOne(Users::className(), ['id' => 'hostid'])->from(['host' => Users::tableName()]);
        
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
    public function getUser0()
    {
        return $this->hasOne(Users::className(), ['id' => 'userid']);
    }
    
    public function getCancelpolicies()
    {
        $cancellationpolicies = Cancellation::find('all')->all();
        return $cancellationpolicies;
    }
}
