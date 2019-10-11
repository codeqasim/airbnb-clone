<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\Reservationssearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Manage Cancelled Payment';
$this->params['subtitle'] =  Yii::t('app', 'Cancelled Payment');
$this->params['breadcrumbs'][]= '';
$baseUrl = Yii::$app->request->baseUrl;
?>
<?php
	echo '<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2>'. Yii::t('app', 'Manage Cancelled Payment').'</h2>
					<div class="panel-ctrls">
					</div>
				</div>
				<div class="panel-body panel-no-padding">';
?>
<?php
//$canceldays = $policies->canceldays;
//$cancelpercentage = $policies->cancelpercentage;
$cancelpolicies = $policies;
foreach($policies as $policy)
{
	$cancelpercentage[] = $policy->cancelpercentage.'<br />';
}
//print_r($cancelpercentage);die;
?>
<div class="reservations-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
<?php Pjax::begin(['id' => 'cancelledpayment']) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
              'attribute' => 'id',
             'label' => Yii::t('app','Transaction Id'),
              'value' => 'invoices.paypaltransactionid'
            ],
            [
              'attribute' => 'userid',
               'label' =>  Yii::t('app','Guest Name'),
              'value' => 'user.firstname'
            ],
            [
              'attribute' => 'hostid',
             'label' => Yii::t('app', 'Host Name'),
              'value' => 'host.firstname',
            ],
			[
				'attribute' => 'cancelby',
				'label' => Yii::t('app','Cancelled By'),
				'value' => 'cancelby'
			],
            [
                'label' =>  Yii::t('app','Total Revenue'),
                'value' => function ($model)
                {
					$fromdate = $model->fromdate;
					$canceldate = $model->canceldate;
					$numDays = abs($fromdate - $canceldate)/60/60/24;
					if($numDays>=180)
						return $model->servicefees;
					else
						return $model->commissionfees + $model->servicefees;
                }
            ],
			[
				'label' =>  Yii::t('app','Actions'),
				'format' => 'raw',
				'value' =>function ($model) {
							$fromdate = $model->fromdate;
							$baseUrl = Yii::$app->request->baseUrl;
							$canceldate = $model->canceldate;
							$numDays = abs($fromdate - $canceldate)/60/60/24;
							$policies = $model->getCancelpolicies();
							$adminamt = 0;
							$selleramt = 0;
							$guestamt = 0;
							foreach($policies as $policy)
							{
								if($numDays>=$policy->cancelfrom && $numDays<=$policy->cancelto)
								{
									if($policy->cancelpercentage==0)
									{
										$adminamt = $model->servicefees;
										$guestamt = $model->total - $model->servicefees;
										$selleramt = 0;
									}
									else if($policy->cancelpercentage!=0)
									{
										$adminamt = $model->commissionfees + $model->servicefees;
										$roomrent = $model->pricepernight * $model->totaldays;
										$selleramt = ($roomrent * $policy->cancelpercentage) / 100;
										$guestamt = $roomrent - $selleramt + $model->taxfees + $model->securityfees;										
									}
								}
								/*if($numDays>=$policy->canceldays && $policy->cancelpercentage==0)
								{
									echo "180";echo '<br />';
									$adminamt = $model->servicefees;
									$guestamt = $model->total - $model->servicefees;
									$selleramt = 0;
								}
								else if($numDays>=$policy->canceldays && $policy->cancelpercentage!=0)
								{
									echo "30";echo '<br />';
									$adminamt = $model->commissionfees + $model->servicefees;
									$roomrent = $model->pricepernight * $model->totaldays;
									$selleramt = ($roomrent * $policy->cancelpercentage) / 100;
									$guestamt = $roomrent - $selleramt + $model->taxfees + $model->securityfees;
								}
								else if($policy->cancelpercentage!=0)
								{
									echo "7";echo '<br />';
									$adminamt = $model->commissionfees + $model->servicefees;
									$roomrent = $model->pricepernight * $model->totaldays;
									$selleramt = ($roomrent * $policy->cancelpercentage) / 100;
									$guestamt = $roomrent - $selleramt + $model->taxfees + $model->securityfees;									
								}*/
							}/* echo '<br />'; */
								return '<input type="button" value="'.Yii::t('app','Approve').'" class="btn btn-success"
								onclick="approve_cancelled_payment('.$model->id.','.$adminamt.','.$selleramt.','.$guestamt.')">
							<a href="'.$baseUrl.'/admin/orders/vieworder/'.$model->id.'">
							<input type="button" value="'.Yii::t('app','View').'" class="btn btn-primary">
							</a>
								';
						},			
	
			],
        ],
    ]); ?>
<div id="paypalfom"></div>
<div class="payment-form"></div>
<?php Pjax::end() ?>
</div>
<?php
	echo '</div>
		</div>
		</div>
        </div>';
?>
<style>
td {
	width:40px;
}
</style>