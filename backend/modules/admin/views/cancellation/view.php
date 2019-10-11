<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Cancellation */

$this->title = $model->id;
$this->params['subtitle'] =Yii::t('app','View Cancellation Policy') ;
$this->params['breadcrumbs'][]= '';
?>
	<div class="panel panel-default" data-widget='{"draggable": "false"}'>
		<div class="panel-heading">
			<h2><?= Yii::t('app',Html::encode($this->title)) ?></h2>
<!-- 				<div class="panel-ctrls"
					data-actions-container="" 
					data-action-collapse='{"target": ".panel-body"}'
					data-action-expand=''
					data-action-colorpicker=''
				>
				</div> -->
		</div>
		<div class="panel-editbox" data-widget-controls=""></div>
		<div class="panel-body">
<div class="cancellation-view">

    

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           [
			'label' => 'ID',
			'value' => $model->id,
		],
		[
			'label' => Yii::t('app',  'Policy Name'),
			'value' => $model->policyname,
		],
		/*[
			'label' => Yii::t('app',  'Policy Limit'),
			'value' => $model->policylimit,
		],
        [
			'label' => Yii::t('app',  'Cancelfrom'),
			'value' => $model->cancelfrom,
		],*/
           [
			'label' => Yii::t('app',  'Days before cancel'),
			'value' => $model->cancelto,
		],
         [
			'label' => Yii::t('app',  'CancelPercentage'),
			'value' => $model->cancelpercentage,
		],
			[
			'label' => Yii::t('app',  'Policy Description'),
			'value' => $model->canceldesc,
		],
        ],
    ]) ?>

</div>
        </div></div>
<style type="text/css">
	
	.cancellation-view > table > tbody > tr >th {
		width:25%;
	}
</style>
