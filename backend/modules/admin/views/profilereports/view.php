<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Lists */

$this->title = $model->report;
$this->params['subtitle'] = ''. Yii::t('app','View Report').'';
$this->params['breadcrumbs'][]= '';
?>
	<div class="panel panel-default" data-widget='{"draggable": "false"}'>
		<div class="panel-heading">
			<h2><?php Yii::t('app',Html::encode($this->title)) ?></h2>	
<!-- 				<div class="panel-ctrls" -->
<!-- 					data-actions-container=""  -->
<!-- 					data-action-collapse='{"target": ".panel-body"}' -->
<!-- 					data-action-expand='' -->
<!-- 					data-action-colorpicker='' -->
<!-- 				> -->
<!-- 				</div> -->
		</div>
		<div class="panel-editbox" data-widget-controls=""></div>
		<div class="panel-body">
<div class="lists-view">

  

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
		
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
		[
			'label' => 'ID',
			'value' => $model->id,
		],
		[
			'label' => Yii::t('app','Report name'),
			'value' => $model->report,
		],
		[
			'label' => Yii::t('app','Report type'),
			'value' => $model->report_type,
		],
[
			'label' =>  Yii::t('app', 'Short Description'),
			'value' => $model->shortdesc,
		],
[
			'label' => Yii::t('app', 'Created Date'),
			'value' => date('M d, Y', strtotime($model->created_time)),
		],
           
        ],
    ]) ?>

</div>
        </div></div>
