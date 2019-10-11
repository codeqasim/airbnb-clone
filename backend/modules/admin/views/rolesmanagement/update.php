<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Lists */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => Yii::t('app','Roles'),
]) . ' ' . $model->name;
$this->params['subtitle'] = '';
$this->params['breadcrumbs'][]= '';
?>
	<div class="panel panel-default" data-widget='{"draggable": "false"}'>
		<div class="panel-heading">
			<h2><?php  //Yii::t('app',Html::encode($this->report)) ?></h2>	
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
<div class="lists-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
        </div></div>
        <style type="text/css">
	.static-content-wrapper {
    width: 100% !important;
	}
</style>