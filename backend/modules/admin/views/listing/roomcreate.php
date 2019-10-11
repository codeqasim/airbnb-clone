<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Roomtype */

$this->title = 'Create Room Type';
$this->params['subtitle'] = Yii::t('app','Create Room Type');
$this->params['breadcrumbs'][]= '';
?>
	<div class="panel panel-default" data-widget='{"draggable": "false"}'>
		<div class="panel-heading">
			<h2><?= Html::encode($this->title) ?></h2>
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
<div class="roomtype-create">


    <?= $this->render('_roomform', [
        'model' => $model,
    ]) ?>

</div>
        </div>
    </div>
