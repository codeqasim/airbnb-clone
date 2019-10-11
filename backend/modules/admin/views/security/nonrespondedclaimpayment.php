<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\models\Claim;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\Claimsearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Non Responded Claim Payment';
$this->params['subtitle'] = Yii::t('app','Non Responded Claim Payment');
$this->params['breadcrumbs'][]= '';
?>
<?php

	echo '<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2> '.Yii::t('app','Non Responded Claim Payment').'</h2>
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
                'label' => Yii::t('app','Transaction Id'),
              'value' => 'invoices.paypaltransactionid'
            ],
            [
                 'label' => Yii::t('app','Guest Name'),
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
                'label' => Yii::t('app','Security Amount'),
                'value' => 'sdamount'
            ],
            [
                'attribute' => 'claimby',
               'label' => Yii::t('app','Claim By'),
                'value' => 'claimby'
            ],
			[
				'label' => Yii::t('app','Actions'),
				'headerOptions' => ['style' => 'width:15%'],
				'format' => 'raw',
				'value' =>function ($model) {
					$baseUrl = Yii::$app->request->baseUrl;
                            $reservation = $model->getReservations($model->reservationid);
                            $totime = time();
                            $enddate = $reservation->todate;
                            $endtime = strtotime('+2 day', $enddate);
                            if($endtime<=$totime)
							{
								if($model->claimby=="Guest")
								$button='<input type="button" value="'.Yii::t('app','Approve').'" class="btn btn-success" onclick="approve_guest_security('.$reservation->id.')">';
								else if($model->claimby=="Host")
								$button='<input type="button" value="'.Yii::t('app','Approve').'" class="btn btn-success" onclick="approve_host_security('.$reservation->id.')">';
							}
                            else
                            $button='<input type="button" value="Approve" class="btn btn-success" disabled>';
						$claimmessages = $model->getmessages($model->id);
						if(!empty($claimmessages))
						{
						$button.='<a href="'.$baseUrl.'/admin/security/viewconversation/'.$model->id.'">
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
<style>
td {
	width:40px;
}
</style>