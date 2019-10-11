<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Reservations */

$this->title = "View Order - ".$model->id;
$this->params['subtitle'] = Yii::t('app','Order') ;
$this->params['breadcrumbs'][]= '';
?>
<div class="panel panel-default" data-widget='{"draggable": "false"}'>
	<div class="panel-heading">
		<h2><?php Yii::t('app','View Order')?></h2>
<!-- 		<div class="panel-ctrls" data-actions-container="" -->
<!-- 			data-action-collapse='{"target": ".panel-body"}' -->
<!-- 			data-action-expand='' data-action-colorpicker=''></div> -->
	</div>
	<div class="panel-editbox" data-widget-controls=""></div>
	<div class="panel-body">
		<div class="reservations-view">
			<?php
			echo '<p>'.Yii::t('app','Payment to').'<br/>
			<b>'.$hostdata->firstname.' '.$hostdata->lastname.'</b>
			<br />
			'.Yii::t('app','Email:').' '.$hostdata->email.'<hr />
			'.Yii::t('app','Booking Duration:').' '.date('M d, Y',$model->fromdate).' <b> '.Yii::t('app','To').' </b>'.date('M d, Y',$model->todate);    

			$checkin=date('h:i A',strtotime($model->checkin));
			$checkout=date('h:i A',strtotime($model->checkout));
			$invoices = $model->getInvoices()->where(['orderid'=>$model->id])->one();
			echo '<br /><b>'.Yii::t('app','Transaction Id:').' '.$invoices['stripe_transactionid'].'</b>';
			if($model->checkin!='0000-00-00 00:00:00' || $model->checkout!='0000-00-00 00:00:00')
			{
				echo '<br><br/>'.'CheckIn: '.$checkin.'<b> To </b>'.$checkout.'</p>'; 
			}			
			echo '<hr />';
			echo '<p>'.Yii::t('app','Buyer Details').'<br />
			<b>'.$guestdata->firstname.' '.$guestdata->lastname.'</b>
			<br />
			'.Yii::t('app','Email:').' '.$guestdata->email.'</p>
			<hr />
			';

            if($model->bookstatus == "accepted" && $model->orderstatus == "pending") {
                echo '<p>'.Yii::t('app','Booking Status').' : '.ucfirst($model->bookstatus).' '.Yii::t('app','by Host').'</p>';
            } else if($model->bookstatus == "accepted" && $model->orderstatus == "paid") {
                
                $other_transaction = json_decode($model->other_transaction, true);
                echo '<br><p><b>'.Yii::t('app','Security Deposit Refund To Guest').'</b></p>';
                echo '<p>'.Yii::t('app','Refund ID').' : '.$other_transaction['refund_id'].'</p>';
                echo '<p>'.Yii::t('app','Refund Status').' : '.ucfirst($other_transaction['status']).'</p>';

                echo '<p>'.Yii::t('app','Refund Amount').' : '.($other_transaction['amount']/100).' '.$other_transaction['currency'].'</p>';

                echo '<p>'.Yii::t('app','Refund Date').' : '.date('M - d, Y',$other_transaction['cdate']).'</p>';

                $other_transaction = json_decode($model->claim_transaction, true);
                echo '<br><p><b>'.Yii::t('app','Host Amount').'</b></p>';
                echo '<p>'.Yii::t('app','Transaction ID').' : '.$other_transaction['claim_id'].'</p>';

                echo '<p>'.Yii::t('app','Transaction Amount').' : '.($other_transaction['amount']/100).' '.$other_transaction['currency'].'</p>';

                echo '<p>'.Yii::t('app','Transaction Date').' : '.date('M - d, Y',$other_transaction['cdate']).'</p>'; 

            } else if($model->bookstatus == "requested") {
                echo '<p>'.Yii::t('app','Booking Status').' : '.ucfirst($model->bookstatus).' '.Yii::t('app','by Guest').'</p>';
            } else if($model->bookstatus == "declined") {
                echo '<p>'.Yii::t('app','Booking Status').' : '.ucfirst($model->bookstatus).' '.Yii::t('app','by Host').'</p>';
                if($model->other_transaction!="") {
                    $other_transaction = json_decode($model->other_transaction, true);
                    echo '<br><p>'.Yii::t('app','Amount Refund To Guest').'</p>';
                    echo '<p>'.Yii::t('app','Refund ID').' : '.$other_transaction['refund_id'].'</p>';
                    echo '<p>'.Yii::t('app','Refund Status').' : '.ucfirst($other_transaction['status']).'</p>';
                    echo '<p>'.Yii::t('app','Refund Date').' : '.date('M - d, Y',$other_transaction['cdate']).'</p>';

                }
            } else if($model->bookstatus == "cancelled" && $model->orderstatus == "pending") {
                echo '<p>'.Yii::t('app','Booking Status').' : '.ucfirst($model->bookstatus).' '.Yii::t('app','by Guest').'</p>';
            } else if($model->bookstatus == "refunded" && $model->orderstatus == "paid") {
                echo '<p>'.Yii::t('app','Booking Status').' : '.ucfirst($model->bookstatus).'</p><br/>';
                if($model->other_transaction!="") {
                    $other_transaction = json_decode($model->other_transaction, true);
                    echo '<br><p><b>'.Yii::t('app','Amount Refund To Guest').'</b></p>';
                    echo '<p>'.Yii::t('app','Refund ID').' : '.$other_transaction['refund_id'].'</p>';
                    echo '<p>'.Yii::t('app','Refund Status').' : '.ucfirst($other_transaction['status']).'</p>';

                    echo '<p>'.Yii::t('app','Refund Amount').' : '.($other_transaction['amount']/100).' '.$other_transaction['currency'].'</p>';

                    echo '<p>'.Yii::t('app','Cancel Percentage').' : '.$other_transaction['percentage'].' % </p>';

                    echo '<p>'.Yii::t('app','Refund Date').' : '.date('M - d, Y',$other_transaction['cdate']).'</p>';
                }

                if($model->claim_transaction!="") { 
                    $other_transaction = json_decode($model->claim_transaction, true);
                    echo '<br><p><b>'.Yii::t('app','Amount Refund To Host').'</b></p>';
                    echo '<p>'.Yii::t('app','Cancel ID').' : '.$other_transaction['deduct_id'].'</p>'; 
                    echo '<p>'.Yii::t('app','Cancel Status').' : '.ucfirst($other_transaction['status']).'</p>';

                    echo '<p>'.Yii::t('app','Cancel Amount').' : '.($other_transaction['amount']/100).' '.$other_transaction['currency'].'</p>';

                    echo '<p>'.Yii::t('app','Cancel Date').' : '.date('M - d, Y',$other_transaction['cdate']).'</p>'; 

                }

            } else if($model->bookstatus == "claimed" && $model->orderstatus == "pending" && $model->claim_status =="pending") {
                echo '<p>'.Yii::t('app','Booking Status').' : '.ucfirst($model->bookstatus).' '.Yii::t('app','by Host').'</p>';
            } else if($model->bookstatus == "claimed" && $model->orderstatus == "pending" && $model->claim_status =="pending") {
                echo '<p>'.Yii::t('app','Booking Status').' : '.ucfirst($model->bookstatus).' '.Yii::t('app','by Host').'</p>';
            } else if($model->bookstatus == "claimed" && $model->orderstatus == "paid" && $model->claim_status =="declined") {
                $other_transaction = json_decode($model->other_transaction, true);
                echo '<br><p><b>'.Yii::t('app','Security Deposit Refund To Guest').'</b></p>';
                echo '<p>'.Yii::t('app','Refund ID').' : '.$other_transaction['refund_id'].'</p>';
                echo '<p>'.Yii::t('app','Refund Status').' : '.ucfirst($other_transaction['status']).'</p>';

                echo '<p>'.Yii::t('app','Refund Amount').' : '.($other_transaction['amount']/100).' '.$other_transaction['currency'].'</p>';

                echo '<p>'.Yii::t('app','Refund Date').' : '.date('M - d, Y',$other_transaction['cdate']).'</p>';

                $other_transaction = json_decode($model->claim_transaction, true);
                echo '<br><p><b>'.Yii::t('app','Claim Amount To Host').'</b></p>';
                echo '<p>'.Yii::t('app','Transaction ID').' : '.$other_transaction['claim_id'].'</p>';
                echo '<p>'.Yii::t('app','Claim Status by Admin').' : '.ucfirst($model->claim_status).'</p>';

                echo '<p>'.Yii::t('app','Transaction Amount').' : '.($other_transaction['amount']/100).' '.$other_transaction['currency'].'</p>';

                echo '<p>'.Yii::t('app','Transaction Date').' : '.date('M - d, Y',$other_transaction['cdate']).'</p>';
            } else if($model->bookstatus == "claimed" && $model->orderstatus == "paid" && $model->claim_status =="approved") {

                $other_transaction = json_decode($model->claim_transaction, true);
                echo '<br><p><b>'.Yii::t('app','Claim Amount To Host').'</b></p>';
                echo '<p>'.Yii::t('app','Claim ID').' : '.$other_transaction['claim_id'].'</p>';
                echo '<p>'.Yii::t('app','Claim Status by Admin').' : '.ucfirst($model->claim_status).'</p>'; 

                echo '<p>'.Yii::t('app','Claim Amount').' : '.($other_transaction['amount']/100).' '.$other_transaction['currency'].'</p>';

                echo '<p>'.Yii::t('app','Claim Date').' : '.date('M - d, Y',$other_transaction['cdate']).'</p>';
            }

            echo '<hr />';
            if($model->booking == "perhour"){
              $nightprice = $model->pricepernight * $model->totalhours;
              $totaldays = $model->totalhours;
            }
            else{
              $nightprice = $model->pricepernight * $model->totaldays;
              $totaldays = $model->totaldays;
            }

            $rate = $model->convertedprice; 

            $nightprice = number_format(round(($nightprice/$rate),2),2,".","");  
            $commissionfees = number_format(round(($model->commissionfees/$rate),2),2,".","");
            $servicefees = number_format(round(($model->servicefees/$rate),2),2,".","");
            $securityfees = number_format(round(($model->securityfees/$rate),2),2,".","");
            $taxfees = number_format(round(($model->taxfees/$rate),2),2,".","");
            $cleaningfees = number_format(round(($model->cleaningfees/$rate),2),2,".","");
            $sitefees = number_format(round(($model->sitefees/$rate),2),2,".","");

            $totalprice = $nightprice + $commissionfees + $servicefees + $securityfees + $taxfees + $cleaningfees + $sitefees;

			echo '<table class="tablesorter table table-striped table-bordered table-condensed">
                <thead>
                    <tr>
                        <th>'.Yii::t('app','SI No').'</th>
                        <th>'.Yii::t('app','Listing Name').'</th>
                        <th>'.Yii::t('app','Duration').'</th>
                        <th>';
                        if($model->booking == "perhour")
                            echo Yii::t('app','Number of Hours');
                        else
                            echo Yii::t('app','Number of days');
                        echo '</th>';
                        if($model->booking == "perhour")
                            echo '<th>'.Yii::t('app','Price per hour').'</th>';
                        else
                            echo '<th>'.Yii::t('app','Price per night').'</th>';
                        
                       echo '<th>'.Yii::t('app','Total Price').'</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>'.$listdata->listingname.'</td>
                        <td>';
                        if($model->booking == "perhour")
                            echo Yii::t('app','Per Hour');
                        else
                            echo Yii::t('app','Per Night');

                        echo '</td><td>';

                        if($model->booking == "perhour")
                            echo $model->totalhours;
                        else
                            echo $model->totaldays;
                        
                    echo '</td><td>'.round(($model->pricepernight/$rate),2).' '.$model->convertedcurrencycode.'</td>';

                    echo '<td>'.$model->total.' '.$model->convertedcurrencycode.'</td></tr>';
            echo '</tbody>
			</table>'; 

			echo '<div class="detaildiv">
                <div class="clear">
                    <div class="leftdivs">'.round(($model->pricepernight/$rate),2).' x '.$totaldays.'</div>
                    <div class="rightdivs">'.$nightprice.' '.$model->convertedcurrencycode.'</div>
                </div>
                <div class="clear">
                    <div class="leftdivs">'.Yii::t('app','Commission Fees').'</div>
                    <div class="rightdivs">'.$commissionfees.' '.$model->convertedcurrencycode.'</div>
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

                <div class="clear">
                    <div class="leftdivs">'.Yii::t('app','Site Fees').'</div>
                    <div class="rightdivs">'.$sitefees.' '.$model->convertedcurrencycode.'</div> 
                </div>

                <div class="clear divline"></div>
                <div class="clear">
                    <div class="leftdivs">'.Yii::t('app','Total').'</div>
                    <div class="rightdivs">'.$totalprice.' '.$model->convertedcurrencycode.'</div> 
                </div>
                <div class="clear divline"></div> 
			</div>';
			?>


		</div>
	</div>
</div>
