<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\Invoicessearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Invoices';
$this->params['subtitle'] =  Yii::t('app', 'Manage Invoices');
$this->params['breadcrumbs'][] = '';
?>
<?php
	echo '<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2>'.Yii::t('app', 'Manage Invoices').'</h2>
					<div class="panel-ctrls">
					</div>
				</div>
				<div class="panel-body panel-no-padding">';
?>
<div class="invoices-index">
<br />
<?php Pjax::begin(['id' => 'invoices']) ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

             [
                'attribute' => 'invoiceno',
 'label' =>  Yii::t('app','Invoice no'),  
            ],
            [
                'attribute' => 'orderid', 
 'label' =>  Yii::t('app','Order id'),  
            ],
            [
                'attribute' => 'invoicedate',
'label' =>  Yii::t('app','Invoice date'), 
                'value' => function ($model)
                {
                    return date('m-d-Y',$model->invoicedate);
                }
            ],
           [
                'attribute' =>  'paymentmethod', 
 'label' =>  Yii::t('app', 'Payment method'),  
            ],
            // 'paypaltransactionid',
            [
                'label' => Yii::t('app','View'),
                'format' => 'raw',
                'value' => function($model)
                {
                    return '<input type="button" value="'.Yii::t('app','View').'" class="btn btn-primary" onclick="view_invoice('.$model->orderid.')">';
                }
            ],
        ],
    ]); ?>

<?php Pjax::end() ?>
</div>
<?php
	echo '</div>
		</div>
		</div>
        </div>';
?>
<div class="invoice-popup-overlay">
	<div class="invoice-popup">
		<div class="closebtn">
			<button class="btn btn-danger pop-close" style="float: right;"><?php echo Yii::t('app','Close');?></button>
            <h3><b><?php echo Yii::t('app','Invoice');?></b></h3>
			<div class="popupdiv" id="invoicediv" style="height: auto;overflow: hidden;">
			</div>
		</div>
	</div>
	<div class="payment-form"></div>
</div>
<style>
td {
	width:30px;
}
</style>