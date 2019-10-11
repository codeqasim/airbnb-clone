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
            $hours=explode('*|*',$model->hourly_booked);
            $bookedhours=date("h:i A", strtotime($hours[0])).'-'.date("h:i A", strtotime($hours[1]));
			echo '<p>'.Yii::t('app','Payment to').'<br/>
			<b>'.$hostdata->firstname.' '.$hostdata->lastname.'</b>
			<br />
			'.Yii::t('app','Email:').' '.$hostdata->email.'<hr />
			'.Yii::t('app','Booking Duration: ').''.date('M d-Y',$model->fromdate).'<b> '.Yii::t('app','To').' </b>'.date('Md-Y',$model->todate).'<p>'.$bookedhours.'</p>';
			$checkin=date('M d-Y',strtotime($model->checkin));
			$checkout=date('M d-Y',strtotime($model->checkout));
			$invoices = $model->getInvoices()->where(['orderid'=>$model->id])->one();
			echo '<br />'.Yii::t('app','Transaction Id:').' '.$invoices['paypaltransactionid'];
			if($model->checkin!='0000-00-00 00:00:00' || $model->checkout!='0000-00-00 00:00:00')
			{
				echo '<br>'.'CheckIn: '.$checkin.'<b> To </b>'.$checkout.'</p>';				
			}			
			echo '<hr />';
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
                        <th>'.Yii::t('app','Duration').'</th>
                        <th>'.Yii::t('app','Number of hours').'</th>
                        <th>'.Yii::t('app','Price per Hour').'</th>
                        <th>'.Yii::t('app','Total Price').'</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>'.$listdata->listingname.'</td>
                        <td>Hourly based</td>
                        <td>'.$model->totalhours.'</td>
                        <td>'.$model->pricepernight.'</td>
                        <td>'.$model->total.'</td>
                    </tr>
                </tbody>
			</table>';
			$nightprice = $model->pricepernight * $model->totalhours;
			$totalprice = $nightprice + $model->commissionfees + $model->servicefees + $model->securityfees + $model->taxfees;
			echo '<div class="detaildiv">
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
			</div>';
			?>


		</div>
	</div>
</div>
