<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\models\Claim;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\Claimsearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Security Deposit Payment For Guest & Host';
$this->params['subtitle'] = Yii::t('app','Security Deposit Payment For Guest & Host');
$this->params['breadcrumbs'][]= '';
?>
<?php
	echo '<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2>'.Yii::t('app','Security Deposit Payment').'</h2>
					<div class="panel-ctrls">
					</div>
				</div>
				<div class="panel-body panel-no-padding">';
?>
<div class="claim-index">


<?php Pjax::begin(['id' => 'approvedpayment']) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
              'label' =>Yii::t('app','Transaction Id'),
              'value' => 'invoices.paypaltransactionid'
            ],
            [
                'label' =>  Yii::t('app','Guest Name'),
                'value' => function($data){
                $reservationdata = Claim::getReservations($data->reservationid);
                return Claim::getHost($reservationdata->userid);
                },
            ],
            [
                'label' => Yii::t('app','Host Name'),
                'value' => function($data){
                $reservationdata = Claim::getReservations($data->reservationid);
                return Claim::getHost($reservationdata->hostid);
                },
            ],
            [
                'attribute' => 'sdamount',
                'label' =>Yii::t('app','Security Amount'),
                'value' => 'sdamount'
            ],
            [
                'attribute' => 'claimby',
                'label' =>Yii::t('app','Claim By'),
                'value' => 'claimby'
            ],
			[
				  'label' =>Yii::t('app','Security Amount'),
				'headerOptions' => ['style' => 'width:15%'],
				'format' => 'raw',
				'value' =>function ($model) {
					$baseUrl = Yii::$app->request->baseUrl;
                            $reservation = $model->getReservations($model->reservationid);
                            $totime = time();
                            $enddate = $reservation->todate;
                            $endtime = strtotime('+2 day', $enddate);
                            if($endtime<=$totime)
                            $button= '<input type="button" value="'.Yii::t('app','Approve').'" class="btn btn-success" onclick="approve_guesthost_security('.$reservation->id.','.$reservation->securityfees.')">';
                            else
                            $button= '<input type="button" value="'.Yii::t('app','Approve').'" class="btn btn-success" disabled>';
						$claimmessages = $model->getmessages($model->id);
						if(!empty($claimmessages))
						{
						$button.='<a href="'.$baseUrl.'/admin/security/viewclaimconversation/'.$model->id.'">
						<input type="button" value="'.Yii::t('app','View').'" class="btn btn-primary"></a>';
						}
						else
						$button.='';
						return $button;					
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
<div class="invoice-popup-overlay">
	<div class="invoice-popup invoicediv">
		<div>
			<button class="btn btn-danger pop-close" style="float: right;"><?php echo Yii::t('app','Close');?></button>
			<div class="popupdiv" id="paydiv" style="height: auto;overflow: hidden;">
				<input type="hidden" id="reserveid">
				<input type="hidden" id="securityamount">
				<div class="col-sm-12"><?php echo Yii::t('app','Total Security Deposit Amount :');?> <span id="totalsecamt"></span></div>
				<div class="col-sm-8"><?php echo Yii::t('app','Pay to');?>
					<select id="payto" onchange="enable_payment(this.value);" class="form-control">
						<option value=""><?php echo Yii::t('app','Select');?></option>
						<option value="guest"><?php echo Yii::t('app','Guest');?></option>
						<option value="host"><?php echo Yii::t('app','Host');?></option>
						<option value="both"><?php echo Yii::t('app','Both');?></option>
					</select>
					<div class="errcls hiddencls" id="paytoerr"></div>
				</div>
				<div id="amtdiv" class="hiddencls col-sm-8">
					<?php echo Yii::t('app','Guest :');?> <input type="text" class="form-control" id="guestamt">
					<?php echo Yii::t('app','Host :');?> <input type="text" class="form-control" id="hostamt">
					<div class="errcls hiddencls" id="amterr"></div>
				</div><br />
				<div class="col-sm-12">
					<input type="button" class="btn btn-success" value="<?php echo Yii::t('app','Pay');?>" onclick="pay_guesthost_security();">
				</div>
					
			</div>
		</div>
	</div>
	<div class="payment-form"></div>
</div>
<style>
td {
	width:40px;
}
</style>