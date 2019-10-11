<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "hts_invoices".
 *
 * @property integer $id
 * @property integer $orderid
 * @property string $invoiceno
 * @property integer $invoicedate
 * @property string $invoicestatus
 * @property string $paymentmethod
 * @property string $paypaltransactionid
 *
 * @property Reservations $order
 */
class Invoices extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hts_invoices';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['orderid', 'invoicedate'], 'integer'],
            [['invoiceno'], 'string', 'max' => 30],
            [['invoicestatus'], 'string', 'max' => 15],
            [['paymentmethod'], 'string', 'max' => 20],
            [['paypaltransactionid'], 'string', 'max' => 150]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'orderid' => 'Orderid',
            'invoiceno' => 'Invoiceno',
            'invoicedate' => 'Invoicedate',
            'invoicestatus' => 'Invoicestatus',
            'paymentmethod' => 'Paymentmethod',
            'paypaltransactionid' => 'Paypaltransactionid',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Reservations::className(), ['id' => 'orderid']);
    }
}
