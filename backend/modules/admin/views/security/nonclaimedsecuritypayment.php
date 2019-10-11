<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\models\Claim;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\Claimsearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Non Claimed Security Deposit Payment';
$this->params['subtitle'] =Yii::t('app', 'Non Claimed Security Deposit Payment');
$this->params['breadcrumbs'][]= '';
?>
<?php
	echo '<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2>'.Yii::t('app','Non Claimed Security Deposit Payment').'</h2>
					<div class="panel-ctrls">
					</div>
				</div>
				<div class="panel-body panel-no-padding">';
?>
<div class="claim-index">

<?php Pjax::begin(['id' => 'approvedpayment']) ?>
<?php
if(isset($dataProvider))
{
	?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            /*[
              'label' => 'Id',
              'value' => 'id'
            ],*/
            [
              'label' =>Yii::t('app','Transaction Id'),
              'value' => 'invoices.paypaltransactionid'
            ],
            [
              'attribute' => 'userid',
             'label' =>  Yii::t('app','Guest Name'),
              'value' => 'user.firstname'
            ],
            [
              'attribute' => 'hostid',
               'label' => Yii::t('app','Host Name'),
              'value' => 'host.firstname'
            ],
			[
				'attribute' => 'securityfees',
				  'label' =>Yii::t('app','Security Amount'),
				'value' => 'securityfees'
			],
			[
				'label' =>  Yii::t('app','Actions'),
				'format' => 'raw',
				'value' =>function ($model) {
                            $reservation = $model->id;
                            $totime = time();
                            $enddate = $model->todate;
                            $endtime = strtotime('+2 day', $enddate);
                            if($endtime<=$totime)
                            return '<input type="button" value="'.Yii::t('app','Approve').'" class="btn btn-success" onclick="approve_guest_security('.$model->id.')">';
                            else
                            return '<input type="button" value="'.Yii::t('app','Approve').'" class="btn btn-success" disabled>';
						},			
	
			],
        ],
    ]); ?>
	<?php
}
else
{
	echo Yii::t('app',"No results found");
}
?>
<div id="paypalfom"></div>
<?php Pjax::end() ?>
</div>
<?php
	echo '</div>
		</div>
		</div>
        </div>';
?>
