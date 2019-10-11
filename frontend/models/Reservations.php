<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "hts_reservations".
 *
 * @property integer $id
 * @property integer $userid
 * @property integer $hostid
 * @property integer $listid
 * @property integer $inquiryid
 * @property integer $fromdate
 * @property integer $todate
 * @property integer $guests
 * @property string $pricepernight
 * @property string $pricedetails
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
            [['userid', 'hostid', 'listid', 'inquiryid', 'fromdate', 'todate', 'guests', 'totaldays','canceldate'], 'integer'],
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
            'inquiryid' => 'Inquiryid',
            'fromdate' => 'Fromdate',
            'todate' => 'Todate',
            'guests' => 'Guests',
            'pricepernight' => 'Pricepernight',
            'pricedetails' => 'Pricedetails',
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
        return $this->hasOne(Users::className(), ['id' => 'userid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHost()
    {
        return $this->hasOne(Users::className(), ['id' => 'hostid']);
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
    
    public function getCurrency()
    {
    	return $this->hasOne(Currency::className(), ['currencycode' => 'currencycode']);
    }
    
    public function getCurrencydetail($currencycode)
    {
        $currency = Currency::find()->where(['currencycode'=>$currencycode])->one();
        return $currency;
    }
    
    /** 
    * @return \yii\db\ActiveQuery 
    */ 
    public function getReviews() 
    { 
        return $this->hasMany(Reviews::className(), ['reservationid' => 'id']); 
    }

    /**
    * List by highly reserved listings.
    * @return \yii\db\ActiveQuery 
    */   
    public function getMaxreservations()
    {
        $reservationlists = Yii::$app->db->createCommand("SELECT 
                            count(g.listid) AS maxapp,
                                             g.listid, 
                                             m.*,
                                             n.roomtype AS roomtypename
                            FROM hts_reservations AS g,
                                 hts_roomtype AS n, 
                                 hts_listing AS m
                            WHERE g.listid = m.id AND 
                                  n.id=m.roomtype AND   
                                  m.liststatus='1'
                            GROUP BY g.listid 
                            HAVING COUNT(*) >= 1 
                            ORDER BY maxapp DESC")->queryAll();
        return $reservationlists;
    }
    public function getReservationDetails()
    {
        $reservationlists = Yii::$app->db->createCommand("SELECT 
                            count(g.listid) AS maxapp,
                                             g.listid, 
                                             m.*,
                                             n.roomtype, 
                                             o.hometype, 
                                             p.image_name,
                                             q.*
                            FROM hts_reservations AS g,
                                 hts_listing AS m, 
                                 hts_roomtype AS n, 
                                 hts_hometype AS o,
                                 hts_photos AS p,
                                 hts_currency AS q
                            WHERE g.listid = m.id AND 
                                  n.id=m.roomtype AND 
                                  m.liststatus='1' AND 
                                  o.id=m.hometype AND 
                                  p.listid=m.id   AND
                                  q.id=m.currency
                            GROUP BY g.listid
                            HAVING COUNT(*) > 1 
                            ORDER BY maxapp DESC limit 4")->queryAll();

        return $reservationlists;
    }
     public function TotalReservationCount()
    {
        $reservationlists = Yii::$app->db->createCommand("SELECT 
                            count(g.listid) AS maxapp,
                                             g.listid, 
                                             m.*,
                                             n.roomtype, 
                                             o.hometype, 
                                             p.image_name,
                                             q.*
                            FROM hts_reservations AS g,
                                 hts_listing AS m, 
                                 hts_roomtype AS n, 
                                 hts_hometype AS o,
                                 hts_photos AS p,
                                 hts_currency AS q
                            WHERE g.listid = m.id AND 
                                  n.id=m.roomtype AND 
                                  m.liststatus='1' AND 
                                  o.id=m.hometype AND 
                                  p.listid=m.id   AND
                                  q.id=m.currency
                            GROUP BY g.listid
                            HAVING COUNT(*) > 1 
                            ORDER BY maxapp DESC")->queryAll();

        return $reservationlists;
    }

     public function TraverseReservationQuery()
    {
        $reservationlists = Yii::$app->db->createCommand("SELECT 
                            count(g.listid) AS maxapp,
                                             g.listid, 
                                             m.*,
                                             n.roomtype, 
                                             o.hometype, 
                                             p.image_name,
                                             q.*
                            FROM hts_reservations AS g,
                                 hts_listing AS m, 
                                 hts_roomtype AS n, 
                                 hts_hometype AS o,
                                 hts_photos AS p,
                                 hts_currency AS q
                            WHERE g.listid = m.id AND 
                                  n.id=m.roomtype AND 
                                  m.liststatus='1' AND 
                                  o.id=m.hometype AND 
                                  p.listid=m.id   AND
                                  q.id=m.currency
                            GROUP BY g.listid
                            HAVING COUNT(*) >= 1 
                            ORDER BY maxapp DESC");

        return $reservationlists;
    }

    public function getInvoicedetails($id)
    {
        return Invoices::find()->where(['id'=>$id])->one();
    }

    public function getListbyid($id)
    {
        return Listing::find()->where(['id'=>$id])->one();
    }
}
