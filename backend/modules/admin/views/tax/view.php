<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Tax */

$this->title = $model->countryname;
$this->params['subtitle'] = Yii::t('app','View Tax');
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
<div class="tax-view">

    <h1><?= Html::encode($this->title) ?></h1>

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
			'label' => Yii::t('app','Countryid'),
			'value' => $model->countryid,
		],
           [
			'label' => Yii::t('app', 'Countryname'),
			'value' => $model->countryname,
		],
           [
			'label' => Yii::t('app',  'Taxname'),
			'value' => $model->taxname,
		],
            [
			'label' => Yii::t('app', 'Percentage'),
			'value' => $model->percentage,
		],
        ],
    ]) ?>

</div>
        </div></div>
