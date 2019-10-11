<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\Reservationssearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Manage Approved Payment';
$this->params['subtitle'] = Yii::t('app','Approved Payment');
$this->params['breadcrumbs'][]= '';
$baseUrl = Yii::$app->request->baseUrl;
?>
<?php
	echo '<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2>'. Yii::t('app', 'Manage Approved Payment').'</h2>
					<div class="panel-ctrls">
					</div>
				</div>
				<div class="panel-body panel-no-padding">';
?>
<div class="reservations-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
<?php Pjax::begin(['id' => 'approvedpayment']) ?>
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
                'attribute' => 'total',
                'label' =>  Yii::t('app','Guest Paid Amount'),
                'value' => 'total',
            ],
            [
              'label' =>  Yii::t('app','Total Revenue'),
                'value' => function ($model)
                {
                    return $model->commissionfees + $model->servicefees;
                }
            ],
            [
                 'label' =>  Yii::t('app','Except Commission'),
                'value' => function ($model)
                {
                    return (($model->pricepernight * $model->totaldays) + $model->taxfees) - $model->commissionfees;
                }
            ],			
            [
                'attribute' => 'currencycode',
 'label' =>  Yii::t('app','Currencycode'),  
            ],
                        
			[
				'label' =>  Yii::t('app','Actions'),
				'format' => 'raw',
				'value' =>function ($model) {
							$enddate = $model->fromdate;
							$baseUrl = Yii::$app->request->baseUrl;
							$todate = strtotime('+1 day', $enddate);
							$today = time();
							if($today>=$todate)
							{
								return '<input type="button" value="'.Yii::t('app','Approve').'" class="btn btn-success" onclick="approve_order('.$model->id.')">
							<a href="'.$baseUrl.'/admin/orders/vieworder/'.$model->id.'">
							<input type="button" value="'.Yii::t('app','View').'" class="btn btn-primary">
							</a>
								';
							}
							else
							{
								return '<input type="button" value="'.Yii::t('app','Approve').'" class="btn btn-success" disabled>
							<a href="'.$baseUrl.'/admin/orders/vieworder/'.$model->id.'">
							<input type="button" value="'.Yii::t('app','View').'" class="btn btn-primary">
							</a>
								';
							}
						},			
	
			],
        ],
    ]); ?>
<div id="paypalfom"></div>
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
	width:70%;
}
</style>