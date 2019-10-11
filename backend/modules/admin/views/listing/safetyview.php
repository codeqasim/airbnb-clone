<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Safetycheck */

$this->title = $model->name;
$this->params['subtitle'] = Yii::t('app','View Safety Checklist');
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
<div class="safetycheck-view">


    <p>
        <?= Html::a(Yii::t('app','Update'), ['safetyupdate', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
		<?php
		$safetylistings = $model->getSafetylistings()->where(['safetyid'=>$model->id])->all();
		if(count($safetylistings)==0)
		{
			?>
        <?= Html::a(Yii::t('app','Delete'), ['safetydelete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' =>  Yii::t('app','Are you sure you want to delete this item?'),
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
			'label' => Yii::t('app','Name'),
			'value' => $model->name,
		],
       [
			'label' => Yii::t('app','Description'),
			'value' => $model-> description,
		],
        ],
    ]) ?>

</div>
</div></div>
