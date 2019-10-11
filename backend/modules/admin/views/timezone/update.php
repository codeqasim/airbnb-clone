<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Timezone */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => Yii::t('app','Timezone'),
]) . ' ' . $model->countryname;
$this->params['subtitle'] = ''. Yii::t('app','Update Time Zone').'';
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
<div class="timezone-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
        </div></div>
