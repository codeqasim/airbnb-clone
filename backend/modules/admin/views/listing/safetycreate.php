<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Safetycheck */

$this->title = 'Create Safety Checklist';
$this->params['subtitle'] = Yii::t('app','Create Safety Checklist');
$this->params['breadcrumbs'][]= '';
?>
	<div class="panel panel-default" data-widget='{"draggable": "false"}'>
		<div class="panel-heading">
		<h2><?= Yii::t('app',Html::encode($this->title)) ?></h2>
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
<div class="safetycheck-create">


    <?= $this->render('_safetyform', [
        'model' => $model,
    ]) ?>

</div>
</div></div>
