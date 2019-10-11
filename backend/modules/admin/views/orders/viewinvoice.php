<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\components\Myclass;
 

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
            '.Yii::t('app','Payment Status:').' '.ucfirst($model->bookstatus).'</p>  
            <hr />  
            ';
            echo '<p>'.Yii::t('app','Buyer Details').'<br />
            <b>'.$guestdata->firstname.' '.$guestdata->lastname.'</b>
            <br />
            '.Yii::t('app','Email:').' '.$guestdata->email.'</p>
            <hr />
            ';

            if($model->currencycode != $model->convertedcurrencycode && !empty($model->currencycode) && !empty($model->convertedcurrencycode)) {
                //listing currency
                $rate1= Myclass::getcurrencyprice($model->currencycode);
               //user currency
               $rate2= Myclass::getcurrencyprice($model->convertedcurrencycode);
            } else {
                $rate1 = "1";
                $rate2 = "1"; 
            }

           $totalPeriod = ($model->booking=="perhour")? 'Number of hours': 'Number of days';
           $pricePeriod = ($model->booking=="perhour")?  'Price per hour':  'Price per night';
           $totalduration = ($model->booking=="perhour")?$model->totalhours:$model->totaldays;
           $durationPrice  = number_format(round(($rate2 * ($model->pricepernight / $rate1)),2),2,".",""); 

            echo '<table class="tablesorter table table-striped table-bordered table-condensed">
                <thead>
                    <tr>
                        <th>'.Yii::t('app','SI No').'</th>
                        <th>'.Yii::t('app','Listing Name').'</th>
                        <th>'.Yii::t('app',$totalPeriod).'</th> 
                        <th>'.Yii::t('app',$pricePeriod).'</th>
                        <th>'.Yii::t('app','Total Price').'</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td> 
                        <td>'.$listdata->listingname.'</td>
                        <td>'.$totalduration.'</td> 
                        <td>'.$model->convertedcurrencycode.' '.$durationPrice.'</td> 
                        <td>'.$model->convertedcurrencycode.' '.$model->total.'</td> 
                    </tr>
                </tbody>
            </table>';
            

            $nightprice = round(($durationPrice * $totalduration),3);
            $listingprice = $model->pricepernight *  $totalduration;

            $listingprice = number_format(round(($rate2 * ($listingprice/ $rate1)),2),2,".","");  

            $commissionfees = number_format(round(($rate2 * ($model->commissionfees / $rate1)),2),2,".","");
            $sitefees = number_format(round(($rate2 * ($model->sitefees / $rate1)),2),2,".","");
            $servicefees = number_format(round(($rate2 * ($model->servicefees / $rate1)),2),2,".","");
            $cleaningfees = number_format(round(($rate2 * ($model->cleaningfees / $rate1)),2),2,".","");
            $securityfees = number_format(round(($rate2 * ($model->securityfees / $rate1)),2),2,".","");
            $taxfees = number_format(round(($rate2 * ($model->taxfees / $rate1)),2),2,".",""); 

            $totalprice = $listingprice + $commissionfees + $sitefees + $servicefees + $cleaningfees + $securityfees + $taxfees;   

            $totalprice = number_format(round(($totalprice),2),2,".","");

            echo '<div class="detaildiv" style="width:50% !important;">
                <div class="clear">
                    <div class="leftdivs">'.$durationPrice.' x '.$totalduration.'</div>
                    <div class="rightdivs">'.$listingprice.' '.$model->convertedcurrencycode.'</div>
                </div>
                <div class="clear">
                    <div class="leftdivs">'.Yii::t('app','Commission Fees').'</div>
                    <div class="rightdivs">'.$commissionfees.' '.$model->convertedcurrencycode.'</div>
                </div>
                 <div class="clear">
                    <div class="leftdivs">'.Yii::t('app','Site Fees').'</div>
                    <div class="rightdivs">'.$sitefees.' '.$model->convertedcurrencycode.'</div>
                </div>
                <div class="clear">
                    <div class="leftdivs">'.Yii::t('app','Service Fees').'</div>
                    <div class="rightdivs">'.$servicefees.' '.$model->convertedcurrencycode.'</div>
                </div>
                <div class="clear">
                    <div class="leftdivs">'.Yii::t('app','Cleaning Fees').'</div>
                    <div class="rightdivs">'.$cleaningfees.' '.$model->convertedcurrencycode.'</div>
                </div>
                <div class="clear">
                    <div class="leftdivs">'.Yii::t('app','Security Deposit').'</div>
                    <div class="rightdivs">'.$securityfees.' '.$model->convertedcurrencycode.'</div>
                </div>
                <div class="clear">
                    <div class="leftdivs">'.Yii::t('app','Tax').'</div>
                    <div class="rightdivs">'.$taxfees.' '.$model->convertedcurrencycode.'</div>
                </div>
                <div class="clear divline"></div>
                <div class="clear">
                    <div class="leftdivs">'.Yii::t('app','Total').'</div>
                    <div class="rightdivs">'.$totalprice.' '.$model->convertedcurrencycode.'</div> 
                </div>
                <div class="clear divline"></div>
            </div>'
            ?>


        </div>
    </div>
</div>
