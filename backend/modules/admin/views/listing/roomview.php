<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Roomtype */

$this->title = $model->roomtype;
$this->params['subtitle'] = Yii::t('app','View Room Type');
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
<div class="roomtype-view">


    <p>
        <?= Html::a(Yii::t('app','Update'), ['roomupdate', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
		<?php
		$roomlistings = $model->getListings()->where(['roomtype'=>$model->id])->all();
		if(count($roomlistings)==0)
		{
			?>
        <?= Html::a(Yii::t('app','Delete'), ['roomdelete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app','Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
		<?php
		}
		?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           [
			'label' => 'ID',
			'value' => $model->id,
		],
        [
			'label' => Yii::t('app', 'Roomtype'),
			'value' => $model-> roomtype,
		],
		[
			'label' => Yii::t('app', 'Roomtype description'),
			'value' => $model->description,
		],
        ],
    ]) ?>

</div>
        </div></div>
