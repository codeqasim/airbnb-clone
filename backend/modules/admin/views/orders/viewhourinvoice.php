<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Reservations */

$this->title = "View Order - ".$model->id;
$this->params['subtitle'] =Yii::t('app','Order') ;
$this->params['breadcrumbs'][]= '';
?>
<div class="panel panel-default" style="padding: 0px !important;border: none;">
    <div class="panel-heading" style="border: none;">
        <h2><?php echo Yii::t('app','Order #');?><?php echo $invoice->invoiceno.' '.Yii::t('app','on').' '.date('m/d/Y',$invoice->invoicedate);?></h2>
    </div>
    <div class="panel-editbox" data-widget-controls=""></div>
    <div class="panel-body">
        <div class="reservations-view">
            <?php
            echo '<p>'.Yii::t('app','Payment Method :').'
            <b>'.$invoice->paymentmethod.'</b>
            <br />
            '.Yii::t('app','Payment Status:').' '.$invoice->invoicestatus.'</p>
            <hr />
            ';
            echo '<p>'.Yii::t('app','Buyer Details').'<br />
            <b>'.$guestdata->firstname.' '.$guestdata->lastname.'</b>
            <br />
            '.Yii::t('app','Email:').' '.$guestdata->email.'</p>
            <hr />
            ';
            echo '<table class="tablesorter table table-striped table-bordered table-condensed">
                <thead>
                    <tr>
                        <th>'.Yii::t('app','SI No').'</th>
                        <th>'.Yii::t('app','Listing Name').'</th>
                        <th>'.Yii::t('app','Number of hours').'</th>
                        <th>'.Yii::t('app','Price per hour').'</th>
                        <th>'.Yii::t('app','Total Price').'</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>'.$listdata->listingname.'</td>
                        <td>'.$model->totalhours.'</td>
                        <td>'.$model->pricepernight.'</td>
                        <td>'.$model->total.'</td>
                    </tr>
                </tbody>
            </table>';
            $nightprice = $model->pricepernight * $model->totalhours;
            $totalprice = $nightprice + $model->commissionfees + $model->servicefees + $model->securityfees + $model->taxfees;
            echo '<div class="detaildiv" style="width:50% !important;">
                <div class="clear">
                    <div class="leftdivs">'.$model->pricepernight.' x '.$model->totalhours.'</div>
                    <div class="rightdivs">'.$nightprice.' '.$model->currencycode.'</div>
                </div>
                <div class="clear">
                    <div class="leftdivs">'.Yii::t('app','Commission Fees').'</div>
                    <div class="rightdivs">'.$model->commissionfees.' '.$model->currencycode.'</div>
                </div>
                <div class="clear">
                    <div class="leftdivs">'.Yii::t('app','Service Fees').'</div>
                    <div class="rightdivs">'.$model->servicefees.' '.$model->currencycode.'</div>
                </div>
                <div class="clear">
                    <div class="leftdivs">'.Yii::t('app','Security Deposit').'</div>
                    <div class="rightdivs">'.$model->securityfees.' '.$model->currencycode.'</div>
                </div>
                <div class="clear">
                    <div class="leftdivs">'.Yii::t('app','Tax').'</div>
                    <div class="rightdivs">'.$model->taxfees.' '.$model->currencycode.'</div>
                </div>
                <div class="clear divline"></div>
                <div class="clear">
                    <div class="leftdivs">'.Yii::t('app','Total').'</div>
                    <div class="rightdivs">'.$totalprice.' '.$model->currencycode.'</div>
                </div>
                <div class="clear divline"></div>
            </div>'
            ?>


        </div>
    </div>
</div>
